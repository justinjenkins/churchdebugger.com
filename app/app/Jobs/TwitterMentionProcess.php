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
