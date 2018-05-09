<?php
namespace App\Repositories\LogHistoryUserLogin;

use Illuminate\Support\ServiceProvider;

class LogHistoryUserLoginRepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\LogHistoryUserLogin\LogHistoryUserLoginInterface',
            'App\Repositories\LogHistoryUserLogin\LogHistoryUserLoginRepository');
    }
}