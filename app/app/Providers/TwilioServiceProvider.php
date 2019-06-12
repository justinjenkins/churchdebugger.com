<?php

namespace App\Providers;

use Twilio\Rest\Client;
use Illuminate\Support\ServiceProvider;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('twilio', function($app) {
            return new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}
