<?php

namespace App\Common;

use Imagick;
use ImagickDraw;

use App\Common\ESV;

class Images {


    //const

    protected $unsplash;

    public static function test(string $term=null) {

        $photo = "https://versesee.com/default_image.jpg";

        // get photo from unsplash api based on term.
        $photos = app()->make('unsplash')->photos($term);
        $photo_count = $photos->getArrayObject()->count();

        if ($photo_count) {
            $photo = $photos->getResults()[mt_rand(0,$photo_count-1)]["urls"]["full"]."&w=1080&h=720&fit=crop";
        }

        $image = new Imagick($photo);

        //$height = $image->getImageHeight();
        //$width = $image->getImageWidth();

        // @todo >> longest verse in the bible >> Esther 8:9
        //$verse = "The king’s scribes were summoned at that time, in the third month, which is the month of Sivan, on the twenty-third day. And an edict was written, according to all that Mordecai commanded concerning the Jews, to the satraps and the governors and the officials of the provinces from India to Ethiopia, 127 provinces, to each province in its own script and to each people in its own language, and also to the Jews in their script and their language.";

        $esv = new ESV;
        $passage = $esv->passage_with_reference($esv->passage($term));

        // @todo change the text color based off the average color of the image??

        // add the text shadow/silhouette first
        $text_shadow = self::draw_silhouette($passage->content);
        $image->compositeImage($text_shadow, Imagick::COMPOSITE_OVER, 0, 0);

        // add the text
        $text = self::draw_text($passage->content);
        $image->compositeImage($text, Imagick::COMPOSITE_OVER, 0, 0);

        // add the reference shadow/silhouette first
        $reference_shadow = self::draw_silhouette("{$passage->reference} ESV", [
            "rows" => 25,
            "border_height" => 25,
            "blur_radius" => 3,
            "blur_sigma" => 1
        ]);
        $image->compositeImage($reference_shadow, Imagick::COMPOSITE_OVER, 0, 550);

        // add the reference
        $reference = self::draw_text("{$passage->reference} ESV", [
            "rows" => 25,
            "border_height" => 25
        ]);
        $image->compositeImage($reference, Imagick::COMPOSITE_OVER, 0, 550);

        header('Content-type: image/jpg');
        echo $image;

    }

    private static function draw_silhouette(string $text=null, array $params=array()) {

        $defaults = [
            "columns" => 780, // 1080-300
            "rows" => 370, // 720-350
            "border_width" => 150,
            "border_height" => 175,
            "blur_radius" => 5,
            "blur_sigma" => 3
        ];

        $params = $params + $defaults;

        $text_shadow = new Imagick();
        $text_shadow->setBackgroundColor('transparent');
        $text_shadow->setGravity (Imagick::GRAVITY_CENTER);
        $text_shadow->setFont('Bookman-Demi');
        $text_shadow->newPseudoImage($params["columns"], $params["rows"], "caption:{$text}");
        $text_shadow->borderImage('transparent', $params["border_width"], $params["border_height"]);
        $text_shadow->colorizeImage('#000000',1, true);
        $text_shadow->blurImage($params["blur_radius"],$params["blur_sigma"]);

        return $text_shadow;

    }

    private static function draw_text(string $text=null, array $params=array()) {
        $defaults = [
            "columns" => 780, // 1080-300
            "rows" => 370, // 720-350
            "border_width" => 150,
            "border_height" => 175,
        ];

        $params = $params + $defaults;

        $text_foreground = new Imagick();
        $text_foreground->setBackgroundColor('transparent');
        $text_foreground->setGravity (Imagick::GRAVITY_CENTER);
        $text_foreground->setFont('Bookman-Demi');
        $text_foreground->newPseudoImage($params["columns"], $params["rows"], "caption:{$text}");
        $text_foreground->borderImage('transparent', $params["border_width"], $params["border_height"]);
        $text_foreground->colorizeImage('#FFFFFF',1, true);

        return $text_foreground;

    }

    public static function overlay_text($image, $text) {

        $image = new Imagick();
        $draw = new ImagickDraw();
        $image = new Imagick('https://local.churchdebugger.com/field.jpg');

        /* Black text */
        $draw->setFillColor('white');
        //$draw->setTextUnderColor ('#00000080');

        $draw->setGravity (Imagick::GRAVITY_CENTER);

        /* Font properties */
        $draw->setFont('Bookman-Demi');
        //$draw->setFontSize( 70 );

        $texts = [];

        $texts[] = "Do not be afraid of sudden terror
  or of the ruin of the wicked, when it comes,
for the LORD will be your confidence
  and will keep your foot from being caught.
  
 Proverbs 3:25-26 (ESV)";

        $texts[] = "Do not be afraid of sudden terror or of the ruin of the wicked, when it comes, for the LORD will be your confidence and will keep your foot from being caught. Proverbs 3:25-26 (ESV)";

        /* Create text */
        $image->annotateImage($draw, 0, 50, 0, $texts[1]);

        //$image->labelImage($texts[1]);

        /* Give image a format */
        $image->setImageFormat('jpg');

        /* Output the image with headers */
        header('Content-type: image/jpg');
        echo $image;


    }

}