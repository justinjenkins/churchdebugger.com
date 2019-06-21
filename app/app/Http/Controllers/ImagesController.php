<?php

namespace App\Http\Controllers;

use App\Image;
use App\Common\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request)
    {

        $message = $request->query('message');
        $twitter_id = $request->query('tid');

        $image = Image::create_base_image($message, $twitter_id);

        Images::generate($image->message, $image->imageid, false);

        return redirect("/images/".$image->imageid);

    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function download(Image $image, Request $request)
    {

        $message = "";
        $imageid = null;

        if (!$image->exists) {
            $message = $request->query('message');
        } else {
            $message = $image->message;
            $imageid = $image->imageid;
        }

        $response = Images::generate($message, $imageid);

        return response($response)->header('Content-Type', 'image/jpg');

    }

}
