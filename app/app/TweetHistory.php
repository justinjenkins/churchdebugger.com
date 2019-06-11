<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TweetHistory extends Model {

    protected $table = 'tweet_history';

    public function scopeLatestFirst($query) {
        return $query->orderBy('twitter_id', 'desc');
    }

}
