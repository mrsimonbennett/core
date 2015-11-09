<?php
namespace FullRent\Core\Deposit\ServiceProviders;

use FullRent\Core\Deposit\Listeners\ContractListener;
use FullRent\Core\Deposit\Listeners\DepositMySqlListenerV2;
use FullRent\Core\Deposit\Repository\BoardWayDepositRepository;
use FullRent\Core\Deposit\Repository\DepositRepository;
use FullRent\Core\Deposit\Repository\SmoothDepositRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class LaravelDepositServiceProvider
 * @package FullRent\Core\Deposit\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelDepositServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DepositRepository::class, SmoothDepositRepository::class);
    }

    /**
     *
     */
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(ContractListener::class));
        $dispatcher->addSubscriber($this->app->make(DepositMySqlListenerV2::class));
    }
}