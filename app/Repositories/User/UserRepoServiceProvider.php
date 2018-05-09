<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 10/25/2016
 * Time: 11:13 AM
 */
namespace App\Repositories\User;

use Illuminate\Support\ServiceProvider;

class UserRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\User\UserInterface', 'App\Repositories\User\UserRepository');
    }
}