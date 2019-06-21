<?php

namespace App\Listeners;

use App\Events\TweetSent;
use App\TwitterMentions;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class TrackTwitterReply
{
    protected $mention;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TwitterMentions $mention)
    {
        $this->mention = $mention;
    }

    /**
     * Handle the event.
     *
     * @param  TweetSent  $event
     * @return void
     */
    public function handle(TweetSent $event)
    {
        //$mention = TwitterMentions::first('twitter_id',$event->id);
        $mention = TwitterMentions::where('twitter_id',$event->id)->first();
        $mention->processed_at = Carbon::now()->format('Y-m-d H:i');
        $mention->save();
    }
}
