<?php

namespace App\Common;

class Words {

    public static function random($input, $count=1) {

        // remove extra spaces
        $input = str_replace('  ',' ',$input);
        // trim up
        $input = trim($input);

        $words = explode(" ", $input);
        $word_count = count($words);

        $rn = mt_rand(0,$word_count-1);

        return $words[$rn];

    }

}