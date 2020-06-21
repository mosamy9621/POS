<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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
        Validator::extend('StockValid',function($attributes,$value,$parameters){
            foreach ($value as $each_quantity){
                return $each_quantity>=$parameters[0] && $each_quantity<=$parameters[1];
            }
        });
        //
    }
}
