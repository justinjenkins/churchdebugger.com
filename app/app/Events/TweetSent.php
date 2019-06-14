<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TweetSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $username;
    public $tweet;
    public $tweet_created_at;
    public $raw_tweet;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $username, $tweet, $tweet_created_at, $raw_tweet)
    {
        $this->id = $id;
        $this->username = $username;
        $this->tweet = $tweet;
        $this->tweet_created_at = $tweet_created_at;
        $this->raw_tweet = $raw_tweet;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
