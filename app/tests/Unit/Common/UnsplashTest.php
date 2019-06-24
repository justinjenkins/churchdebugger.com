<?php

namespace Tests\Unit\Common;

use Tests\TestCase;
use App\Common\Unsplash;

class UnsplashTest extends TestCase
{

    public function test_fix_image_url_dimensions() {

        $url = "https://images.unsplash.com/photo-1523311964370-42ac336c878b?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb";

        $updated_url = Unsplash::fix_image_url_dimensions($url, ["fit" => "crop", "width" => 1080, "height" => 720]);
        $this->assertEquals(
            "https://images.unsplash.com/photo-1523311964370-42ac336c878b?fit=crop&w=1080&h=720&ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb",
            $updated_url
        );

    }


}
