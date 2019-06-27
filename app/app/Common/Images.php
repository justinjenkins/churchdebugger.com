<?php

namespace App\Common;

use Imagick;

class Images
{

    /**
     * [JPG] Normal full composite image (text over background)
     */
    const TYPE_FULL_COMPOSITE = 1;
    /**
     * [PNG] Only generate the overlay text (transparent background)
     */
    const TYPE_OVERLAY_ONLY = 2;

    /**
     * @param string $imageid
     * @param string $background_url
     * @param string|null $passage
     * @param string|null $reference
     * @param int $type
     * @param bool $break_cache
     * @return string
     * @throws \ImagickException
     */
    public static function generate(
        string $imageid,
        string $background_url,
        string $passage = null,
        string $reference = null,
        int $type = Images::TYPE_FULL_COMPOSITE,
        bool $break_cache = false
    ) {

        $image_file = Images::get_file_and_path($imageid, $type);

        if (!$break_cache && file_exists($image_file)) {
            return $image_file;
        }

        if ($type == Images::TYPE_OVERLAY_ONLY) {
            $background_url = public_path() . "/background.png";
        }

        $image = new Imagick($background_url);
        $image->stripImage();

        //$height = $image->getImageHeight();
        //$width = $image->getImageWidth();

        // @todo change the text color based off the average color of the image??

        // add the text shadow/silhouette first
        $text_shadow = self::draw_silhouette($passage);
        $image->compositeImage($text_shadow, Imagick::COMPOSITE_OVER, 0, 0);

        // add the text
        $text = self::draw_text($passage);
        $image->compositeImage($text, Imagick::COMPOSITE_OVER, 0, 0);

        // add the reference shadow/silhouette first
        $reference_shadow = self::draw_silhouette("{$reference} ESV", [
            "rows" => 25,
            "border_height" => 25,
            "blur_radius" => 3,
            "blur_sigma" => 1
        ]);
        $image->compositeImage($reference_shadow, Imagick::COMPOSITE_OVER, 0, 550);

        // add the reference
        $reference = self::draw_text("{$reference} ESV", [
            "rows" => 25,
            "border_height" => 25
        ]);
        $image->compositeImage($reference, Imagick::COMPOSITE_OVER, 0, 550);


        // add watermark
        $watermark_shadow = self::draw_silhouette("versesee", [
            "rows" => 18,
            "border_height" => 10,
            "font" => "AvantGarde-Book",
            "blur_radius" => 5,
            "blur_sigma" => 1
        ]);
        $image->compositeImage($watermark_shadow, Imagick::COMPOSITE_OVER, 475, 670);

        // add watermark
        $watermark = self::draw_text("versesee", [
            "rows" => 18,
            "border_height" => 10,
            "font" => "AvantGarde-Book",
            //Imagick::GRAVITY_SOUTHEAST
        ]);
        $image->compositeImage($watermark, Imagick::COMPOSITE_OVER, 475, 670);

        if ($type == Images::TYPE_OVERLAY_ONLY) {
            $image->setFormat("png");
        } else {
             $image->setFormat("jpg");
        }

        // creates a "progressive" JPG that will load better in the browser (sort of "blurs in" as it loads)
        $image->setInterlaceScheme(Imagick::INTERLACE_PLANE);
        $image->setImageCompressionQuality(85);
        $image->stripImage();

        if ($image_file) {
            $image->writeImage($image_file);
        }

        $image->destroy();

        return $image_file;

    }

    /**
     * @deprecated Please use Image->file_and_path or Image->filename instead.
     * @param string $imageid
     * @param int $type
     * @return string Returns the file name and path together
     */
    public static function get_file_and_path(string $imageid, int $type=Images::TYPE_FULL_COMPOSITE)
    {

        $image_name = "image-{$imageid}";
        $file_type = "jpg";

        if ($type == Images::TYPE_OVERLAY_ONLY) {
            $image_name = "image-overlay-{$imageid}";
            $file_type = "png";
        }

        return public_path() . "/cache/{$image_name}.{$file_type}";

    }

    /**
     * @param string|null $text
     * @param array $params
     * @return Imagick
     * @throws \ImagickException
     */
    private static function draw_silhouette(string $text = null, array $params = array())
    {

        $defaults = [
            "columns" => 780, // 1080-300
            "rows" => 370, // 720-350
            "border_width" => 150,
            "border_height" => 175,
            "blur_radius" => 5,
            "blur_sigma" => 3,
            "font" => "Bookman-Demi",
            "gravity" => Imagick::GRAVITY_CENTER,
        ];

        $params = $params + $defaults;

        $text_shadow = new Imagick();
        $text_shadow->setBackgroundColor('transparent');
        $text_shadow->setGravity($params["gravity"]);
        $text_shadow->setFont($params["font"]);
        $text_shadow->newPseudoImage($params["columns"], $params["rows"], "caption:{$text}");
        $text_shadow->borderImage('transparent', $params["border_width"], $params["border_height"]);
        $text_shadow->colorizeImage('#000000', 1, true);
        $text_shadow->blurImage($params["blur_radius"], $params["blur_sigma"]);

        return $text_shadow;

    }

    /**
     * @param string|null $text
     * @param array $params
     * @return Imagick
     * @throws \ImagickException
     */
    private static function draw_text(string $text = null, array $params = array())
    {

        $defaults = [
            "columns" => 780, // 1080-300
            "rows" => 370, // 720-350
            "border_width" => 150,
            "border_height" => 175,
            "font" => "Bookman-Demi",
            "gravity" => Imagick::GRAVITY_CENTER,
        ];

        $params = $params + $defaults;

        $text_foreground = new Imagick();
        $text_foreground->setBackgroundColor('transparent');
        $text_foreground->setGravity($params["gravity"]);
        $text_foreground->setFont($params["font"]);
        $text_foreground->newPseudoImage($params["columns"], $params["rows"], "caption:{$text}");
        $text_foreground->borderImage('transparent', $params["border_width"], $params["border_height"]);
        $text_foreground->colorizeImage('#FFFFFF', 1, true);

        return $text_foreground;

    }

}