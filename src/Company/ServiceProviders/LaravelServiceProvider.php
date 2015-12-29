<?php
namespace FullRent\Core\Company\ServiceProviders;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\Listeners\TenancyListener;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\Projection\MySqlCompanyReadRepository;
use FullRent\Core\Company\Projection\Subscribers\ApplicationEventListener;
use FullRent\Core\Company\Projection\Subscribers\MysqlCompanySubscriber;
use FullRent\Core\Company\SmoothCompanyRepository;
use FullRent\Core\Infrastructure\FullRentServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\CompanyModal\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelServiceProvider extends FullRentServiceProvider

{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompanyRepository::class, SmoothCompanyRepository::class);
        $this->app->bind(CompanyReadRepository::class, MysqlCompanyReadRepository::class);


    }

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [
            TenancyListener::class,
            MysqlCompanySubscriber::class,
            ApplicationEventListener::class,
        ];
    }
}