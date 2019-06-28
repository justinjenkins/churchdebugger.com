<?php

namespace App\Http\Controllers;

use App\Common\Images;
use App\Common\VerseSee;
use App\Common\Unsplash;
use App\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function store(Request $request)
    {
        /*
        $attributes = request()->validate([
            'message' => 'required|min:3|max:255',
            'twitter_id' => 'nullable|numeric'
        ]);
        */

        if (!$request->input('message')) {
            return abort(400, 'No `message` parameter.');
        }

        $message = $request->input('message', "");
        $twitter_id = $request->input('twitter_id', null);

        $image = Image::create_base_image($message, $twitter_id);

        VerseSee::compose_image($image);

        return redirect("/" . $image->imageid);

    }

    public function show(Image $image)
    {

        $photo_url = null;

        if ($image->unsplash_id) {
            $photo_url = Unsplash::photo_html_url_from_id($image->unsplash_id);
        }

        $type = "single";

        return view('images.show', compact('image', 'type', 'photo_url'));
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

        return response()->file($image->file_and_path());

    }

    public function daily(string $lang=null)
    {
        $image = Image::votd($lang);
        $type = "votd";
        return view('images.show', compact('image','type'));
    }

    public function seek()
    {
        $type = "seek";
        return view('images.seek', compact('type'));
    }

    public function timeline()
    {
        $images = Image::orderBy('id', 'desc')->paginate(15);
        $type = "timeline";
        return view('images.timeline', compact('images', 'type'));
    }

    public function overlay(Image $image)
    {
        VerseSee::compose_image($image, [ "type" => Images::TYPE_OVERLAY_ONLY ]);
        return response()->file($image->file_and_path(Images::TYPE_OVERLAY_ONLY));
    }

}
