<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:14 AM
 */
namespace App\Repositories\CV;

use Illuminate\Support\ServiceProvider;

class CVRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\CV\CVInterface', 'App\Repositories\CV\CVRepository');
    }
}