<?php

namespace App\Common;

use Twilio\Twiml as TTwiml;

class Twiml {

    protected $twiml;

    public function __construct() {
        $this->twiml = new TTwiml;
    }

    public function respond_with_text(string $response_text, array $params) {

        $defaults = array (
            "message" => null,
            "media" => null,
        );

        $params = $params + $defaults;

        $message = $this->twiml->message();

        $message->body(htmlentities($response_text));

        if ($params["media"]) {
            $message->media($params["media"]);
        }

        return $this->twiml;
    }

}