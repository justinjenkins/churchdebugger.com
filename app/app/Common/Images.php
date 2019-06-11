<?php

namespace App\Common;

use Imagick;
use ImagickDraw;

class Images {

    protected $unsplash;

    public static function test() {

        //$image = new Imagick("http://placehold.it/1280x720");
        $image = new Imagick("https://local.churchdebugger.com/field3.jpg");
        $height = $image->getImageHeight();
        $width = $image->getImageWidth();

        $text = new Imagick();


        $texts = [];

        $texts[] = "Do not be afraid of sudden terror or of the ruin of the wicked, when it comes, for the LORD will be your confidence and will keep your foot from being caught. Proverbs 3:25-26 (ESV)";

        // longest verse in the bible >> Esther 8:9
        $texts[] = "The king’s scribes were summoned at that time, in the third month, which is the month of Sivan, on the twenty-third day. And an edict was written, according to all that Mordecai commanded concerning the Jews, to the satraps and the governors and the officials of the provinces from India to Ethiopia, 127 provinces, to each province in its own script and to each people in its own language, and also to the Jews in their script and their language.";

        $texts[] = "Just joking, chill.";

        $text->setBackgroundColor('transparent');
        $text->setGravity (Imagick::GRAVITY_CENTER);
        $text->setFont('Bookman-Demi');
        //$text->setFillColor('white');

        //$text->newPseudoImage(1000, 500, "caption:{$texts[1]}");
        $text->newPseudoImage(1080-300, 720-300, "caption:{$texts[2]}");

        $text->borderImage('transparent', 150, 150);
        $text->colorizeImage('#FFFFFF',1, true);

        $image->compositeImage($text, Imagick::COMPOSITE_OVER, 0, 0);

        header('Content-type: image/jpg');
        echo $image;

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