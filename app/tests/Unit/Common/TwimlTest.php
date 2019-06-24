<?php

namespace Tests\Unit\Common;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Common\Twiml;

class TwimlTest extends TestCase
{

    public function test_respond_with_text_has_proper_xml()
    {

        $expected = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<Response><Message><Body>text message body</Body></Message></Response>'."\n";

        $twiml = new Twiml();
        $actual = $twiml->respond_with_text("text message body", []);

        // we could bother to check the whole XML structure but
        // this is just as good since this is so simple and done over HTTP anyhow
        $this->assertEquals($expected, (string) $actual);

    }
}
