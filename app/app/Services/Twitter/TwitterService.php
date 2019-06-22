<?php

namespace App\Services\Twitter;

interface TwitterService
{
    public function get_mentions($since = null);

    public function send_tweet($text, $in_reply_to = null, $media_ids = null);

    public function upload_media_urls($urls);
}
