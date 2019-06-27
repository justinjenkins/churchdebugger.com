<?php

namespace App\Common;

use GuzzleHttp;

class Biblegateway
{

    protected $client;

    private $base_uri = "https://www.biblegateway.com/";

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client();
    }

    /**
     * Get the Verse of the Day
     * @param array $params
     * @return object
     */
    public function votd(array $params = [])
    {

        $verse = (object) array();

        $defaults = [
            "version" => 47,
            "format" => "json"
        ];

        $params = $params + $defaults;

        $passages = null;

        $url = $this->base_uri . "/votd/get/?version={$params["version"]}&format={$params["format"]}";

        try {
            $response = $this->client->get($url);
        } catch (GuzzleHttp\Exception\ClientException  $exception) {
            $response = $exception->getResponse();
        }

        $contents = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() == 200) {
            $verse = $contents->votd;
        }

        return $verse;
    }

}