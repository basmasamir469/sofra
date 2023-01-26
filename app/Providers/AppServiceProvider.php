<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
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
        //
        App::singleton('auth_resturant_id',function(){
            return auth('api-resturants')->user()->id;
        });

        App::singleton('auth_client_id',function(){
            return auth('api-clients')->user()->id;
        });

    }
}
