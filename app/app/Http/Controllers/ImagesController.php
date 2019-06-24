<?php

namespace App\Http\Controllers;

use App\Common\Images;
use App\Common\VerseSee;
use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request)
    {

        $message = $request->input('message', "");
        $twitter_id = $request->input('twitter_id', null);

        $image = Image::create_base_image($message, $twitter_id);

        VerseSee::compose_image($image);

        return redirect("/" . $image->imageid);

    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function download(Image $image, Request $request)
    {

        // this will only happen with request to random.jpg
        if (!$image->exists) {

            if (!$request->query('message')) {
                return abort(400, 'No `message` parameter.');
            }

            $image = Image::create_base_image($request->query('message'));
            // redirect to the image by imageid
            return redirect("/images/" . $image->imageid . ".jpg");
        }

        // this is a catch all in case the image isn't already composed
        VerseSee::compose_image($image);

        return response()->file(Images::get_file_and_path($image->imageid));

    }

}
