<?php

namespace App\Http\Controllers;

use App\Image;
use App\Common\Images;
use App\Common\VerseSee;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request)
    {

        $message = $request->query('message');
        $twitter_id = $request->query('tid');

        $image = Image::create_base_image($message, $twitter_id);

        $new_image = VerseSee::compose_image($image);

        return redirect("/images/".$image->imageid);

    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function download(Image $image, Request $request)
    {

        // will only happen with request to random.jpg
        if (!$image->exists) {
            $image = Image::create_base_image($request->query('message'));
        }

        // @todo this won't work with 'random' unless we create a create a base image before??

        $new_image = VerseSee::compose_image($image);
        return Images::render($new_image->imageid);

        //$response = Images::generate($message, $imageid);
        //return response($response)->header('Content-Type', 'image/jpg');

    }

}
