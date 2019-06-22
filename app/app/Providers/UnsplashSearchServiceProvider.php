<?php

namespace App\Providers;

use Crew\Unsplash as Unsplash;
use Illuminate\Support\ServiceProvider;


class UnsplashSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('unsplash-search', function ($app) {
            return new Unsplash\Search;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Unsplash\HttpClient::init([
            'applicationId' => env('UNSPLASH_ACCESS_KEY'),
            'utmSource' => 'Church Debugger Demo'
        ]);
    }
}
