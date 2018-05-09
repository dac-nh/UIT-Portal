<?php
namespace App\Repositories\Validation;

use Illuminate\Support\ServiceProvider;

class ValidationRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\Validation\ValidationInterface', 'App\Repositories\Validation\ValidationRepository');
    }
}