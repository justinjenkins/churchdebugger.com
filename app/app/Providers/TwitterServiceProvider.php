<?php

namespace App\Providers;

use App\Services\Twitter\CodebirdTwitterService;
use App\Services\Twitter\TwitterService;
use Codebird\Codebird;
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
            $codebird->setToken(config('services.twitter.access_token'), config('services.twitter.access_token_secret'));
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
        Codebird::setConsumerKey(config('services.twitter.consumer_key'), config('services.twitter.secret_key'));
    }
}
