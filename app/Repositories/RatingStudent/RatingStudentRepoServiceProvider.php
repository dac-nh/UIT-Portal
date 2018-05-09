<?php
namespace App\Repositories\RatingStudent;

use Illuminate\Support\ServiceProvider;

class RatingStudentRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\RatingStudent\RatingStudentInterface',
            'App\Repositories\RatingStudent\RatingStudentRepository');
    }
}