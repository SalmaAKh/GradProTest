<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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


        Blade::if('Admin', function () {
            if(auth()->check())
                return auth()->user()->isAdministrator();
            return false;
        });

        Blade::if('Instructor', function () {
            if(auth()->check())
                return auth()->user()->isInstructor();
            return false;
        });

    }
}
