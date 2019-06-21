<?php

namespace App\Jobs;


use App\Common\Images;
use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImageGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $image;
    public $message;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

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
    public function __construct(string $message, Image $image)
    {
        $this->image = $image;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo ">> Creating image for {$this->image->twitter_id}\n";
        Images::generate($this->message, $this->image->imageid, false);
        echo ">> Done\n";
    }
}
