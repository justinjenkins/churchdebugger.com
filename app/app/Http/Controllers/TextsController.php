<?php

namespace App\Http\Controllers;

use App\Common\Twiml;
use App\Text;
use Illuminate\Http\Request;

class TextsController extends Controller
{

    public function store(Request $request)
    {

        $message = $request->input('Body', null);;

        $text = new Text;
        $text->message = $message;
        $text->save();

        $twiml = new Twiml;

        $response = $twiml->respond_with_text("📖", [
            "media" => request()->getSchemeAndHttpHost() . "/images/random.jpg?message=" . urlencode($message),
            "message" => $message
        ]);

        return response($response)->header('Content-Type', 'application/xml');
    }

}
