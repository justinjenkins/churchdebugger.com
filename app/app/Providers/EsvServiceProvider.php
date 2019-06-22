<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EsvServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->client = new GuzzleHttp\Client(['headers' => ["Authorization" => "Token " . env("ESV_TOKEN")]]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
