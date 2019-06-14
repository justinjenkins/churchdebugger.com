<?php

namespace App\Listeners;

use App\Events\TweetSent;
use App\TweetHistory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackTwitterReply
{
    protected $tweet;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TweetHistory $tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Handle the event.
     *
     * @param  TweetSent  $event
     * @return void
     */
    public function handle(TweetSent $event)
    {
        $this->tweet->create([
            'twitter_id' => $event->id,
            'username' => $event->username,
            'tweet' => $event->tweet,
            'tweet_created_at' => $event->tweet_created_at,
            'raw_tweet' => $event->raw_tweet,
        ]);
    }
}
