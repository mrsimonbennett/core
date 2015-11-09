<?php
namespace FullRent\Core\User\ServiceProviders;

use FullRent\Core\User\Projections\MysqlUserReadRepository;
use FullRent\Core\User\Projections\Subscribers\UserMysqlSubscriber;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\SmoothUserRepository;
use FullRent\Core\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\User\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelServiceProvider extends ServiceProvider
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
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(UserMysqlSubscriber::class));
    }
}