<?php
namespace FullRent\Core\User\ServiceProviders;

use FullRent\Core\User\EventStoreUserRepository;
use FullRent\Core\User\UserRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(UserRepository::class, EventStoreUserRepository::class);
    }
}