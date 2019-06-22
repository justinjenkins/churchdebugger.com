<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TwitterMentions extends Model
{
    protected $fillable = [
        'twitter_id',
        'username',
        'tweet',
        'tweet_created_at',
        'raw_tweet',
        'processed_at'
    ];

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('twitter_id', 'desc');
    }

    public function scopeLastProcessed($query)
    {
        return $query->whereNotNull('processed_at')->orderBy('twitter_id', 'desc')->first();
    }

    public function scopeLatestUnprocessedFirst($query)
    {
        return $query->whereNull('processed_at')->orderBy('twitter_id', 'desc');
    }
}
