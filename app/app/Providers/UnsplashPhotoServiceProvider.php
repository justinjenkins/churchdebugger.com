<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Crew\Unsplash;

class UnsplashPhotoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('unsplash-photo', function ($app) {
            return new Unsplash\Photo;
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
