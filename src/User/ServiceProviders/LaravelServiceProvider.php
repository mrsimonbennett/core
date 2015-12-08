<?php
namespace FullRent\Core\User\ServiceProviders;

use FullRent\Core\Infrastructure\FullRentServiceProvider;
use FullRent\Core\User\Listener\ContractTenantListener;
use FullRent\Core\User\Listener\UserEmailListener;
use FullRent\Core\User\Projections\MysqlUserReadRepository;
use FullRent\Core\User\Projections\Subscribers\UserMysqlSubscriber;
use FullRent\Core\User\Projections\Subscribers\UserSettingsSubscriber;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\SmoothUserRepository;
use FullRent\Core\User\UserRepository;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\User\ServiceProviders
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
        $this->app->bind(UserRepository::class, SmoothUserRepository::class);
        $this->app->bind(UserReadRepository::class, MysqlUserReadRepository::class);


    }

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [
            ContractTenantListener::class,
            UserMysqlSubscriber::class,
            UserEmailListener::class,
            UserSettingsSubscriber::class,
        ];
    }
}