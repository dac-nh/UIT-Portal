<?php

namespace App\Repositories\University;

use Illuminate\Support\ServiceProvider;

class UniversityRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\University\UniversityInterface', 'App\Repositories\University\UniversityRepository');
    }

}