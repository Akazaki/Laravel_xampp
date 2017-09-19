<?php

namespace Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvidor extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^foo/', $value);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
