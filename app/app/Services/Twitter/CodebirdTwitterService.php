<?php

namespace App\Services\Twitter;

use App\Services\Twitter\Exceptions\RateLimitExceededException;
use Codebird\Codebird;

class CodebirdTwitterService implements TwitterService
{

    protected $client;

    public function __construct(Codebird $client)
    {
        $this->client = $client;
    }

    public function get_mentions($since = null)
    {
        $mentions = $this->client->statuses_mentionsTimeline($since ? 'since_id=' . $since : '');

        // rate limit handling
        if ((int)$mentions->rate->remaining === 0) {
            throw new RateLimitExceededException;
        }

        return collect($this->reduce_to_tweets($mentions));
    }

    public function send_tweet($text, $in_reply_to = null, $media_ids = null)
    {
        $params = [
            'status' => $text
        ];

        if ($in_reply_to) {
            $params['in_reply_to_status_id'] = $in_reply_to;
        }

        if ($media_ids) {
            $params['media_ids'] = $this->array_to_csv_string($media_ids);
        }

        $this->client->statuses_update($params);

    }

    public function upload_media_urls($urls)
    {

        $media_ids = [];

        foreach ($urls as $url) {
            $upload = $this->client->media_upload([
                'media' => $url
            ]);
            $media_ids[] = $upload->media_id_string;
        }

        return $media_ids;

    }

    protected function reduce_to_tweets($response)
    {

        unset($response->rate);
        unset($response->httpstatus);

        return $response;

    }

    private function array_to_csv_string($arr)
    {
        return implode(",", $arr);
    }

}