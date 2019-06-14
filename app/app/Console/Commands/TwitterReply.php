<?php

namespace App\Console\Commands;

use App\Jobs\ImageGenerate;
use App\Jobs\TwitterMentionProcess;
use App\TweetHistory;
use App\Jobs\TwitterReplier;
use Illuminate\Console\Command;
use App\Services\Twitter\TwitterService;
use App\Services\Twitter\Exceptions\RateLimitExceededException;
use App\Common\Words;

class TwitterReply extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:reply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replies to twitter mentions.';

    protected $twitter;
    protected $unsplash;

    /**
     * Create a new command instance.
     *
     * @param
     * @return void
     */
    public function __construct(TwitterService $twitter) {
        parent::__construct();
        $this->unsplash = app()->make('unsplash');
        $this->twitter = $twitter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TweetHistory $tweet_history) {

        $tweets = $tweet_history->latestFirst();

        try {

            $last_id = null;

            if ($tweets->count()) {
                $last_id = $tweets->first()->twitter_id;
            }

            $mentions = $this->twitter->get_mentions($last_id);

        } catch (RateLimitExceededException $e) {
            return $this->error('Twitter API rate limit exceeded.');
        }

        if (!$mentions->count()) {
            return $this->info('No new mentions.');
        }

        $texts = $mentions->map(function ($mention) {
            $text_cleanup = str_replace('@versesee','',$mention->text);
            // @todo we could use a "key word" API to try and get a single word to use
            // for now we'll just pick an random word from the tweet
            return Words::random($text_cleanup);
        });

        $mentions->each(function ($mention, $index) use ($texts) {

            $term = $texts[$index];
            $image_url_to_attach = env("APP_URL")."/images/1/?term=".urlencode("{$texts[$index]}")."&tid={$mention->id}";

            // we need to generate the image first and cache it
            // this is because Twitter will timeout if the image
            // takes too long to come back, thus the chained jobs

            TwitterMentionProcess::withChain([
                new ImageGenerate(
                    $mention->id,
                    $term
                ),
                new TwitterReplier(
                    $mention->id,
                    $mention->user->screen_name,
                    "📖",
                    $image_url_to_attach
                ),
            ])->dispatch($mention, $term);

        });

    }
}
