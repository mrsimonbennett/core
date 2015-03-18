<?php
namespace App\Http\Companies;

use Illuminate\Support\ServiceProvider;

final class CompaniesHttpServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['router']->group([], function($router)
        {
            require app_path('Http/Companies/routes.php');
        });
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