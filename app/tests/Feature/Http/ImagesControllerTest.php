<?php

namespace Tests\Feature\Http;

use App\Image;
use function Psy\debug;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * To debug the responses the following can be used
     *
     * $response->dumpHeaders();
     * $response->dump();
     *
     */

    const MESSAGE = "lamb";
    const TWITTER_ID = "1";

    public function test_redirect_of_random_dot_jpg()
    {
        $this->get('/images/random.jpg')->assertStatus(500);

        $response = $this->get('/images/random.jpg?message=lamb');
        $response->assertStatus(302)
            ->assertHeader('location');

        $redirect_url = $response->headers->get('Location');
        $redirect_url_parsed = parse_url($redirect_url);

        $response->assertRedirect($redirect_url);

        $this->assertNotContains("random.jpg",$redirect_url);

        // should match a 8 char .jpg file name
        $this->assertRegExp('/\/images\/([a-zA-Z0-9]{8})*\.jpg/', $redirect_url_parsed["path"]);

    }

    public function test_store_image()
    {

        $response = $this
            ->post('/images',["message" => self::MESSAGE, "twitter_id" => self::TWITTER_ID])
            ->assertStatus(302);

        $redirect_url = $response->headers->get('Location');
        $redirect_url_parsed = parse_url($redirect_url);

        $response->assertRedirect($redirect_url);

        // url should match a 8 char image name
        $this->assertRegExp('/\/([a-zA-Z0-9]{8})*/', $redirect_url_parsed["path"]);

        // make sure things look right in the database
        $imageid = self::get_imageid_from_url($redirect_url);

        $image = Image::where('imageid', $imageid)->first();
        $this->assertNotNull($image,
            "Database: Cannot return Image from database");

        $this->assertEquals("lamb",$image->message,
            "Database: `message` is not set to '{self::MESSAGE}'");
        $this->assertEquals("1",$image->twitter_id,
            "Database:  `twitter_id` is not set to '{self::TWITTER_ID}'");

        $this->assertNotNull($image->unsplash_id,
            "Database: `unsplash_id` is null");
        $this->assertNotNull($image->reference,
            "Database: `reference` is null");
        $this->assertNotNull($image->passage_text,
            "Database: `passage_text` is null");

    }

    public function test_view_image()
    {

        $response = $this
            ->followingRedirects()
            ->post('/images',["message" => self::MESSAGE, "twitter_id" => self::TWITTER_ID])
            ->assertStatus(200)
            ->assertViewHas('image');

        $imageid = self::get_imageid_from_url(url()->current());

        $response->assertSee('<img src="/images/'.$imageid.'.jpg" />');

    }

    private static function get_imageid_from_url($url) {
        $url_parts = parse_url($url);

        $ex = explode("/", $url_parts["path"]);
        $imageid = end($ex);

        return $imageid;
    }


}
