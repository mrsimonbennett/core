<?php
namespace FullRent\Core\Deposit\ServiceProviders;

use FullRent\Core\Deposit\Repository\BoardWayDepositRepository;
use FullRent\Core\Deposit\Repository\DepositRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(DepositRepository::class, BoardWayDepositRepository::class);
    }
}