<?php

namespace App\Jobs;


use App\Common\Images;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImageGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $twitter_id;
    public $term;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $twitter_id, string $term)
    {
        $this->twitter_id = $twitter_id;
        $this->term = $term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo ">> Creating image for {$this->twitter_id}\n";
        Images::generate($this->term, $this->twitter_id, false);
        echo ">> Done\n";
    }
}
