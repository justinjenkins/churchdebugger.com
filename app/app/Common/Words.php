<?php

namespace App\Common;

/**
 * Class Words
 * @package App\Common
 */
class Words
{

    /**
     * @param $input
     * @param int $count
     * @return mixed
     */
    public static function random($input, $count = 1)
    {

        // remove extra spaces
        $input = str_replace('  ', ' ', $input);
        // trim up
        $input = trim($input);

        $words = explode(" ", $input);
        $word_count = count($words);

        $rn = mt_rand(0, $word_count - 1);

        return $words[$rn];

    }

    /**
     * Remove text from a string
     * @param string $text Basic string
     * @param array $params Parameters for removal
     * @return string
     */
    public static function remove(string $text, array $params = array())
    {

        $defaults = [
            "starts_with" => null,
            "search" => null
        ];

        $params = $params + $defaults;

        $exploded_text = explode(" ", $text);

        if ($params["search"]) {
            if (is_array($params["search"])) {
                $text = Words::remove_characters($params["search"], $exploded_text);
            } else {
                $text = Words::remove_whole_word($params["search"], $exploded_text);
            }
        }

        if ($params["starts_with"]) {
            $text = Words::remove_starts_with($params["starts_with"], $exploded_text);
        }

        return $text;

    }

    /**
     * @param array $characters
     * @param array $exploded_text
     * @return string
     */
    private static function remove_characters(array $characters, array $exploded_text)
    {

        foreach ($exploded_text as $key => $word) {
            $exploded_text[$key] = str_replace($characters, "", $word);
        }

        return implode(" ", $exploded_text);

    }

    /**
     * @param string $word
     * @param array $exploded_text
     * @return string
     */
    private static function remove_whole_word(string $word, array $exploded_text)
    {

        foreach ($exploded_text as $key => $eword) {
            if ($word == $eword) {
                unset($exploded_text[$key]);
            }
        }

        return implode(" ", $exploded_text);

    }

    /**
     * @param string $starts_with
     * @param array $exploded_text
     * @return string
     */
    private static function remove_starts_with(string $starts_with, array $exploded_text)
    {

        foreach ($exploded_text as $key => $word) {
            if (strlen($word) && isset($word[strlen($starts_with) - 1]) && $word[strlen($starts_with) - 1] == $starts_with) {
                unset($exploded_text[$key]);
            }
        }

        return implode(" ", $exploded_text);

    }

    /**
     * @param $text
     * @return string
     */
    public static function remove_at_mentions($text)
    {
        return Words::remove($text, $params = ["starts_with" => "@"]);
    }

    /**
     * @param $text
     * @return string
     */
    public static function remove_hashtags($text)
    {
        return Words::remove($text, $params = ["starts_with" => "#"]);
    }

    /**
     * @param $text
     * @return string
     */
    public static function remove_punctuation($text)
    {
        $punctuation = ["?", "!", ",", ".", ";", ":", ";", "'", "(", ")", "&"];
        return Words::remove($text, $params = ["search" => $punctuation]);
    }

}