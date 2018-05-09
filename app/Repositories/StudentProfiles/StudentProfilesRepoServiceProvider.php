<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:56 AM
 */
namespace App\Repositories\StudentProfiles;

use Illuminate\Support\ServiceProvider;

class StudentProfilesRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\StudentProfiles\StudentProfilesInterface', 'App\Repositories\StudentProfiles\StudentProfilesRepository');
    }
}