<?php
namespace FullRent\Core\Tenancy;

use FullRent\Core\Infrastructure\FullRentServiceProvider;
use FullRent\Core\Tenancy\Listeners\TenancyMysqlListener;
use FullRent\Core\Tenancy\Listeners\TenancyRentBookListener;
use FullRent\Core\Tenancy\Repositories\SmoothTenancyRepository;
use FullRent\Core\Tenancy\Repositories\TenancyRepository;

/**
 * Class TenancyServiceProvider
 * @package FullRent\Core\Tenancy
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyServiceProvider extends FullRentServiceProvider
{

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [
            TenancyMysqlListener::class,
            TenancyRentBookListener::class,
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TenancyRepository::class, SmoothTenancyRepository::class);
    }
}