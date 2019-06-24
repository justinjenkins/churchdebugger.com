<?php

namespace App\Common;

class Unsplash
{

    public static function photo_url_from_id(string $id, array $params = array())
    {
        $defaults = [
            "width" => "1080",
            "height" => "720",
            "fit" => "crop"
        ];

        $params = $params + $defaults;

        $photo = app()->make('unsplash-photo')->find($id);

        return Unsplash::fix_image_url_dimensions($photo->download(), $params);

    }

    public static function photo_from_message($message)
    {

        $photo = "https://versesee.com/default_image.jpg";

        // get photo from unsplash api based on message.
        $photos = app()->make('unsplash-search')->photos($message);
        $photo_count = $photos->getArrayObject()->count();

        if ($photo_count) {
            //$photo = $photos->getResults()[mt_rand(0,$photo_count-1)]["urls"]["full"]."&w=1080&h=720&fit=crop";
            $photo = $photos->getResults()[mt_rand(0, $photo_count - 1)];
        }

        return $photo;

    }

    public static function image_url_from_photo(array $photo, array $params = array())
    {

        $defaults = [
            "width" => "1080",
            "height" => "720",
            "fit" => "crop"
        ];

        $params = $params + $defaults;

        return Unsplash::fix_image_url_dimensions($photo["urls"]["full"], $params);

        //return $photo["urls"]["full"]."&w={$params["width"]}&h={$params["height"]}&fit={$params["fit"]}";

    }

    public static function fix_image_url_dimensions(string $url, array $params)
    {

        $query_string_names = [
            "width" => "w",
            "height" => "h"
        ];

        foreach ($params as $key => $value) {
            if (isset($query_string_names[$key])) {
                $params[$query_string_names[$key]] = $value;
                unset($params[$key]);
            }
        }

        $url_parsed = parse_url($url);

        $url_query_string = $url_parsed["query"];

        parse_str($url_query_string, $query_string);

        $query_string = $params + $query_string;

        $url_parsed["query"] = http_build_query($query_string);

        return Url::build($url_parsed);

    }

}