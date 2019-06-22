<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class Image extends Model
{

    protected $fillable = [
        'message',
        'passage_text',
        'reference',
        'unsplash_id',
        'twitter_id'
    ];

    public function twitter_mentions()
    {
        return $this->hasOne('App\TwitterMentions', 'twitter_id', 'twitter_id');
    }

    public function getRouteKeyName()
    {
        return 'imageid';
    }

    /**
     * Generate a new "random" 8 char imageid
     *
     * @return string|null
     * @throws Exception
     */
    public static function generate_imageid()
    {

        $imageid = null;
        $limit = 25;
        $counter = 0;

        while (!Image::find($imageid) && $counter <= $limit) {
            $imageid = bin2hex(random_bytes(4));
            $counter++;
        }

        if (!$imageid) {
            throw new Exception('Unable to generate unique imageid.');
        }

        return $imageid;

    }

    public static function create_base_image(string $message="", string $twitter_id=null)
    {
        $image = new Image;
        $image->imageid = Image::generate_imageid();
        $image->message = $message;
        $image->twitter_id = $twitter_id;
        $image->save();

        return $image;
    }

}
