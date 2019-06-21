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
        $tid = $request->query('tid');

        $image = new Image;
        $image->imageid = Image::generate_imageid();
        $image->message = $message;
        $image->twitter_id = $tid;
        $image->save();

        Images::generate($message, $image->imageid, false);

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
