<?php

namespace App;

use App\Common\Biblegateway;
use App\Common\VerseSee;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Common\Images;

use Illuminate\Support\Facades\Cache;

class Image extends Model
{

    protected $fillable = [
        'message',
        'passage_text',
        'reference',
        'translation',
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

    public static function create_base_image(string $message = "", string $twitter_id = null)
    {
        $image = new Image;
        $image->imageid = Image::generate_imageid();
        $image->message = $message;
        $image->twitter_id = $twitter_id;
        $image->save();

        return $image;
    }

    public static function votd(string $lang=null)
    {

        if (!$lang) { $lang = "eng"; }

        $key = "votd-{$lang}-".date("Ymd");

        $verse = Cache::remember($key, 86400, function () {
            $biblegateway = new Biblegateway;
            $votd = $biblegateway->votd();

            $image = self::create_base_image("bible");
            $image->passage_text = $votd->content;
            $image->reference = $votd->reference;
            $image->save();

            $votd->imageid = $image->imageid;

            return $votd;
        });

        $image = Image::where('imageid', $verse->imageid)->first();

        VerseSee::compose_image($image);

        return $image;
    }

    /**
     * @param int $type
     * @return string Returns the file name and path together
     */
    public function file_and_path(int $type=Images::TYPE_FULL_COMPOSITE)
    {

        $image_filename = $this->filename($type);

        return public_path() . "/cache/{$image_filename}";

    }

    public function filename(int $type=Images::TYPE_FULL_COMPOSITE)
    {
        $image_name = "image-{$this->imageid}";
        $file_type = "jpg";

        if ($type == Images::TYPE_OVERLAY_ONLY) {
            $image_name = "image-overlay-{$this->imageid}";
            $file_type = "png";
        }

        return "{$image_name}.{$file_type}";

    }

}
