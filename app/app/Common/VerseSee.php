<?php

namespace App\Common;

use App\Image;

class VerseSee
{

    /**
     * Compose a VerseSee image
     *
     * @param Image $image
     * @param array $params
     * @return Image
     */
    public static function compose_image(Image $image, array $params=array())
    {

        $defaults = [
            'type' => Images::TYPE_FULL_COMPOSITE,
        ];

        $params = $params + $defaults;

        $background_url = null;

        // @todo >> longest verse in the bible >> Esther 8:9
        //$verse = "The king’s scribes were summoned at that time, in the third month, which is the month of Sivan, on the twenty-third day. And an edict was written, according to all that Mordecai commanded concerning the Jews, to the satraps and the governors and the officials of the provinces from India to Ethiopia, 127 provinces, to each province in its own script and to each people in its own language, and also to the Jews in their script and their language.";

        // lookup the passage and save to the Image
        if (!$image->passage_text && !$image->reference) {
            $image = VerseSee::add_passage_to_image($image);
        }

        // if we have a background image id already get the photo url from the id
        if ($image->unsplash_id && !$background_url) {
            $background_url = Unsplash::photo_url_from_id($image->unsplash_id);
        }

        // lookup a background image and save it to the Image
        if (!$image->unsplash_id) {

            $photo = Unsplash::photo_from_message($image->message);

            if (is_array($photo)) {
                $background_url = Unsplash::image_url_from_photo($photo);
                $image = VerseSee::add_background_to_image($image, $photo);
            } elseif (is_string($photo)) {
                $background_url = $photo;
            }
        }

        // @todo since this is the slowest part it could be moved to it's own job.
        Images::generate(
            $image->imageid,
            $background_url,
            $image->passage_text,
            $image->reference,
            $params["type"],
            false
        );

        return $image;
    }

    /**
     * @param Image $image
     * @return Image
     */
    private static function add_passage_to_image(Image $image)
    {
        $esv = new ESV;
        $passage = $esv->passage_with_reference($esv->passage($image->message));
        $image->passage_text = $passage->content;
        $image->reference = $passage->reference;
        $image->save();

        return $image;
    }

    /**
     * @param Image $image
     * @param array $photo
     * @return Image
     */
    private static function add_background_to_image(Image $image, array $photo)
    {
        $image->unsplash_id = $photo["id"];
        $image->save();

        return $image;
    }


}