<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.application.nav_project', '\App\View\Composers\NavProjectComposer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}