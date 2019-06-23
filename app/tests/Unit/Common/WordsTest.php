<?php

namespace Tests\Unit\Common;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Common\Words;

class WordsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_remove_string() {

        $string = "foo bar baz barbar";

        $removed_string = Words::remove($string, ["search" => "bar"]);
        $this->assertEquals("foo baz barbar", $removed_string);

    }


    public function test_remove_at_mentions() {

        $string = "@foo foo @bar baz barbar";

        $removed_string = Words::remove_at_mentions($string, ["search" => "bar"]);
        $this->assertEquals("foo baz barbar", $removed_string);

        $string = " ";

        $removed_string = Words::remove_at_mentions($string, ["search" => "bar"]);
        $this->assertEquals(" ", $removed_string);

        $string = "";

        $removed_string = Words::remove_at_mentions($string, ["search" => "bar"]);
        $this->assertEquals("", $removed_string);


    }

    public function test_remove_hashtags() {

        $string = "#4see foo bar #baz barbar # foo #foo";

        $removed_string = Words::remove_hashtags($string);
        $this->assertEquals("foo bar barbar foo", $removed_string);

        $string = " ";

        $removed_string = Words::remove_hashtags($string);
        $this->assertEquals(" ", $removed_string);

        $string = "";

        $removed_string = Words::remove_hashtags($string);
        $this->assertEquals("", $removed_string);

    }

    public function test_remove_punctuation() {

        $string = ".@vers!!es'ee #4se:e. foo bar, #b,az bar'bar;; # fo&o! #foo";

        $removed_string = Words::remove_punctuation($string);
        $this->assertEquals("@versesee #4see foo bar #baz barbar # foo #foo", $removed_string);

    }



}
