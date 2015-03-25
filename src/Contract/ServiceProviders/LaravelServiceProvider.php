<?php
namespace FullRent\Core\Contract\ServiceProviders;

use FullRent\Core\Contract\BroadWayContractRepository;
use FullRent\Core\Contract\ContractRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\Contract\ServiceProviders
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
        $this->app->bind(ContractRepository::class,BroadWayContractRepository::class);
    }
}