<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TweetHistory extends Model {

    protected $table = 'tweet_history';

    protected $fillable = [
        'twitter_id',
        'username',
        'tweet',
        'tweet_created_at',
        'raw_tweet'
    ];

    public function scopeLatestFirst($query) {
        return $query->orderBy('twitter_id', 'desc');
    }

}
