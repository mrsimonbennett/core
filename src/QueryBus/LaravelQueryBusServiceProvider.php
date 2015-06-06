<?php
namespace FullRent\Core\QueryBus;

use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelQueryBusServiceProvider
 * @package FullRent\Core\QueryBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelQueryBusServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueryTranslator::class,SimpleQueryTranslator::class);
        $this->app->bind(QueryBus::class,LaravelQueryBus::class);

    }
}