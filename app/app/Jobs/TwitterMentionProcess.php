<?php

namespace App\Jobs;

use App\TwitterMentions;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TwitterMentionProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mention;
    public $term;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mention, $term)
    {
        $this->mention = $mention;
        $this->term = $term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TwitterMentions $mention)
    {
        //
    }
}
