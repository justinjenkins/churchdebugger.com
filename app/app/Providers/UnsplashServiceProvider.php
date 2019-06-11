<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Crew\Unsplash as Unsplash;


class UnsplashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('unsplash', function ($app) {
            return new Unsplash\Search;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Unsplash\HttpClient::init([
            'applicationId'	=> env('UNSPLASH_ACCESS_KEY'),
            'utmSource' => 'Church Debugger Demo'
        ]);
    }
}
