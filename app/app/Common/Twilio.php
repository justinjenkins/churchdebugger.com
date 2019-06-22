<?php

namespace App\Common;

class Twilio
{

    protected $twilio;

    public function __construct()
    {
        $this->twilio = app()->make('twilio');
    }

    public function send_sms(string $number_to, array $params = array())
    {

        $defaults = array(
            "from" => env("TWILIO_DEFAULT_PHONE"),
            "body" => "🖐"
        );

        $params = $params + $defaults;

        $send = $this->twilio->messages->create($number_to, $params);

        return $send;
    }

}