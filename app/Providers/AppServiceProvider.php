<?php

namespace App\Providers;


use Illuminate\Support\Facades\Schema;;
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
        //para  el tamanio de los caracteres en la base de datos
        Schema::defaultStringLength(191);
    }
}
