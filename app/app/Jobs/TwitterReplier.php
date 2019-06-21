<?php

namespace App\Jobs;

use App\Events\TweetSent;
use App\Services\Twitter\TwitterService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TwitterReplier implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id;
    public $screen_name;
    public $text;
    public $media_url;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     * @param $id
     * @param $screen_name
     * @param $text
     * @param null $media_url
     *
     * @return void
     */
    public function __construct($id, $screen_name, $text, $media_url=null)
    {
        $this->id = $id;
        $this->screen_name = $screen_name;
        $this->text = $text;
        $this->media_url = $media_url;
    }

    /**
     * Execute the job.
     *
     * @param TwitterService $twitter
     * @return void
     */
    public function handle(TwitterService $twitter)
    {

        $media_ids = $twitter->upload_media_urls([$this->media_url]);

        $twitter->send_tweet("@{$this->screen_name} {$this->text}", $this->id, $media_ids);

        // @todo we should record the id of the reply tweet sent
        event(new TweetSent($this->id));

        echo ">> Replied to {$this->id}\n";
    }

}
