<?php

namespace App\Console\Commands;

use App\Image;
use App\Jobs\ImageGenerate;
use App\Jobs\TwitterMentionProcess;
use App\TwitterMentions;
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

    /**
     * TwitterReply constructor.
     * @param TwitterService $twitter
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(TwitterService $twitter)
    {
        parent::__construct();
        $this->twitter = $twitter;
    }

    /**
     * Execute the console command.
     * @param TwitterMentions $twitter_mentions
     * @return void
     */
    public function handle(TwitterMentions $twitter_mentions)
    {

        $last_processed_tweet = $twitter_mentions->lastProcessed();

        try {

            $last_id = null;

            if ($last_processed_tweet->count()) {
                $last_id = $last_processed_tweet->first()->twitter_id;
            }

            $mentions = $this->twitter->get_mentions($last_id);

        } catch (RateLimitExceededException $e) {
            return $this->error('Twitter API rate limit exceeded.');
        }

        if (!$mentions->count()) {
            return $this->info('No new mentions.');
        }

        $texts = $mentions->map(function ($mention) {

            $text_cleanup = Words::remove_at_mentions($mention->text);
            $text_cleanup = Words::remove_hashtags($text_cleanup);
            $text_cleanup = Words::remove_punctuation($text_cleanup);

            // we could use a "key word" API to try and get a single word to use
            // for now we'll just pick an random word from the tweet
            return Words::random($text_cleanup);

        });

        $mentions->each(function ($mention, $index) use ($texts) {

            $message = $texts[$index];

            $image = Image::create_base_image($message, $mention->id);

            $image_url_to_attach = env("APP_URL")."/images/{$image->imageid}.jpg";

            // we need to generate the image first and cache it
            // this is because Twitter will timeout if the image
            // takes too long to come back, thus the chained jobs

            TwitterMentionProcess::withChain([
                new ImageGenerate(
                    $image
                ),
                new TwitterReplier(
                    $mention->id,
                    $mention->user->screen_name,
                    "📖",
                    $image_url_to_attach
                ),
            ])->dispatch($mention, $image);

        });

    }
}
