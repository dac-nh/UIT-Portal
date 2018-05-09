<?php
/**
 * Created by PhpStorm.
 * User: Dark Wolf
 * Date: 11/18/2016
 * Time: 11:14 AM
 */
namespace App\Repositories\Company;

use Illuminate\Support\ServiceProvider;

class CompanyRepoServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\Company\CompanyInterface', 'App\Repositories\Company\CompanyRepository');
    }
}