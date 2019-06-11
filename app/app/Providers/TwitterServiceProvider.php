<?php

namespace App\Providers;

use Codebird\Codebird;
use App\Services\Twitter\TwitterService;
use App\Services\Twitter\CodebirdTwitterService;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TwitterService::class, function ($app) {
            $codebird = Codebird::getInstance();
            $codebird->setToken(env('TWITTER_ACCESS_TOKEN'),env('TWITTER_ACCESS_TOKEN_SECRET'));
            return new CodebirdTwitterService($codebird);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Codebird::setConsumerKey(env('TWITTER_CONSUMER_KEY'),env('TWITTER_SECRET_KEY'));
    }
}
