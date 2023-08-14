<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('valid_encoding', function ($attribute, $value, $parameters, $validator) {
            $currentEncoding = mb_detect_encoding($value, 'UTF-8, ISO-8859-1');

            if ($currentEncoding !== 'UTF-8') {
                $fixedString = mb_convert_encoding($value, 'UTF-8', $currentEncoding);
            } else {
                $fixedString = $value;
            }

            return $fixedString;
        });
    }

}
