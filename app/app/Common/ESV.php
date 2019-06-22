<?php

namespace App\Common;

use GuzzleHttp;

class ESV
{

    protected $client;

    // the issue here is that the ESV API won't let us know how many pages are available without making a request
    // so therefore the searches tend to be from the first books of the bible instead of really random
    // we can probably fix this by doing two requests (one to get the page count, and then another with a random
    // page count number.

    private $passage_uri = "https://api.esv.org/v3/passage/search/?page-size=100&q=";

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['headers' => ["Authorization" => "Token " . env("ESV_TOKEN")]]);
    }

    public function passage_search(string $message, array $params = [])
    {

        $defaults = [
            "passage_and_reference" => false
        ];

        $params = $params + $defaults;

        $passages = null;

        try {
            $response = $this->client->get($this->passage_uri . "{$message}");
        } catch (GuzzleHttp\Exception\ClientException  $exception) {
            $response = $exception->getResponse();
        }

        $contents = json_decode($response->getBody()->getContents());

        if ($response->getStatusCode() == 200 && $contents->total_results != 0) {
            $passages = $contents->results;
        }

        // @todo handle this better ... if we get an error it just searches for a bible verse with "error" in it :)
        if (!$passages) {

            if ($params["passage_and_reference"]) {
                return [];
            } else {
                return "error";
            }

        }

        $passage = $passages[mt_rand(0, count($passages) - 1)];

        if ($params["passage_and_reference"]) {
            return $passage;
        }

        return $passage->content;
    }

    public function passage(string $message)
    {
        return $this->passage_search($message);;
    }

    public function passage_with_reference(string $message)
    {
        return $this->passage_search($message, ["passage_and_reference" => true]);
    }

}