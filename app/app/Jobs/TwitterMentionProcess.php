<?php

namespace App\Jobs;

use App\TwitterMentions;
use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class TwitterMentionProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mention;
    public $image;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 15;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mention, Image $image)
    {
        $this->mention = $mention;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tweet = new TwitterMentions();
        $tweet->twitter_id = $this->mention->id;
        $tweet->username = $this->mention->user->screen_name;
        $tweet->tweet = $this->mention->text;
        $tweet->tweet_created_at = Carbon::parse($this->mention->created_at)->format('Y-m-d H:i');
        $tweet->raw_tweet = json_encode($this->mention);
        $tweet->save();
    }
}
