<?php
namespace App\Repositories\UserApplyProject;

use Illuminate\Support\ServiceProvider;

class UserApplyProjectRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\UserApplyProject\UserApplyProjectInterface', 'App\Repositories\UserApplyProject\UserApplyProjectRepository');
    }
}