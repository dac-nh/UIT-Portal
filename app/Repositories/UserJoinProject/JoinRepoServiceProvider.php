<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 1:26 PM
 */
namespace App\Repositories\UserJoinProject;

use Illuminate\Support\ServiceProvider;

class JoinRepoServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('App\Repositories\UserJoinProject\JoinInterface', 'App\Repositories\UserJoinProject\JoinRepository');
    }

}