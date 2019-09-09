<?php

namespace App\Providers;

use ArkonEvent\CodeReadr\ApiClient\Client;
use Illuminate\Contracts\Container\Container;
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
        $this->app->instance(
            Client::class,
            new Client(config('codereadr.key'))
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
