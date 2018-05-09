<?php
namespace App\Repositories\Project;

use Illuminate\Support\ServiceProvider;

class ProjectRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\Project\ProjectInterface', 'App\Repositories\Project\ProjectRepository');
    }
}