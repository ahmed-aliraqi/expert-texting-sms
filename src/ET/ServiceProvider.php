<?php

namespace Aliraqi\ET;

use Illuminate\Support\ServiceProvider as Provider;

class ServiceProvider extends Provider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/sms_et.php' => config_path('sms_et.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/sms_et.php', 'sms_et'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sms', SMS::class);
    }
}
