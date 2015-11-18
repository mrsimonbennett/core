<?php
namespace FullRent\Core\Property\ServiceProviders;

use FullRent\Core\Property\Listener\PropertyApplicationEmailListener;
use FullRent\Core\Property\PropertyRepository;
use FullRent\Core\Property\Read\MysqlPropertiesReadRepository;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\Read\Subscribers\MysqlPropertySubscriber;
use FullRent\Core\Property\Read\Subscribers\PropertyHistorySubscriber;
use FullRent\Core\Property\SmoothPropertyRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\Property\ServiceProviders
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
        $this->app->bind(PropertyRepository::class, SmoothPropertyRepository::class);
        $this->app->bind(PropertiesReadRepository::class, MysqlPropertiesReadRepository::class);
    }

    /**
     *
     */
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(MysqlPropertySubscriber::class));
        $dispatcher->addSubscriber($this->app->make(PropertyHistorySubscriber::class));
        $dispatcher->addSubscriber($this->app->make(PropertyApplicationEmailListener::class));

    }
}