<?php
namespace FullRent\Core\Application\Http\Composer;

use FullRent\Core\Application\Http\Composer\Dashboard\AllDashboardComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Layout\DashboardLayoutLeftSideBarComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Properties\DashboardPropertiesCreateComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Properties\DashboardPropertiesEditComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Properties\DashboardPropertiesIndexComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Properties\DashboardPropertiesShowComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\DashboardTenanciesDraftComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\DashboardTenanciesIndexComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\DashboardTenanciesShowComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook\DashboardTenanciesRentBookAddComposer;
use FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook\DashboardTenanciesRentBookChangeComposer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposeServiceProvider
 * @package FullRent\Core\Application\Http\Composer
 * @author Simon Bennett <simon@bennett.im>
 */
final class ComposeServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     *
     */
    public function boot()
    {
        /** @var Factory $view */
        $view = $this->app->make('Illuminate\Contracts\View\Factory');
        $view->composer('dashboard.*', AllDashboardComposer::class);
        $view->composer('dashboard.layout.left-sidebar', DashboardLayoutLeftSideBarComposer::class);

        $view->composer('dashboard.properties.index', DashboardPropertiesIndexComposer::class);
        $view->composer('dashboard.properties.create', DashboardPropertiesCreateComposer::class);
        $view->composer('dashboard.properties.show', DashboardPropertiesShowComposer::class);
        $view->composer('dashboard.properties.edit', DashboardPropertiesEditComposer::class);


        $view->composer('dashboard.tenancies.index', DashboardTenanciesIndexComposer::class);
        $view->composer('dashboard.tenancies.show', DashboardTenanciesShowComposer::class);
        $view->composer('dashboard.tenancies.draft', DashboardTenanciesDraftComposer::class);

        $view->composer('dashboard.tenancies.rentbook.add', DashboardTenanciesRentBookAddComposer::class);
        $view->composer('dashboard.tenancies.rentbook.change', DashboardTenanciesRentBookChangeComposer::class);

    }
}