<?php
namespace FullRent\Core\Contract\ServiceProviders;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\Listeners\ContractApplicationListener;
use FullRent\Core\Contract\Listeners\ContractMailListener;
use FullRent\Core\Contract\Listeners\ContractMysqlListener;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Contract\Query\MysqlContractReadRepository;
use FullRent\Core\Contract\SmoothContractRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

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
        $this->app->bind(ContractRepository::class, SmoothContractRepository::class);
        $this->app->bind(ContractReadRepository::class, MysqlContractReadRepository::class);
    }

    /**
     *
     */
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(ContractApplicationListener::class));
        $dispatcher->addSubscriber($this->app->make(ContractMailListener::class));
        $dispatcher->addSubscriber($this->app->make(ContractMysqlListener::class));

    }
}