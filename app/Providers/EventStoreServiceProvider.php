<?php namespace FullRent\Core\Application\Providers;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use EventStore\Broadway\BroadwayEventStore;
use EventStore\EventStore;
use FullRent\Core\Application\Infrastructure\BroadWayToLaravelEvents;
use FullRent\Core\Application\Infrastructure\LogEvents;
use FullRent\Core\Application\Infrastructure\SlackNotifications;
use Illuminate\Support\ServiceProvider;

class EventStoreServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EventBusInterface::class, SimpleEventBus::class);

        /** @var EventBusInterface $eventBus */
        $eventBus = $this->app->make(EventBusInterface::class);
        $eventBus->subscribe($this->app->make(LogEvents::class));
        $eventBus->subscribe($this->app->make(BroadWayToLaravelEvents::class));
        $eventBus->subscribe($this->app->make(SlackNotifications::class));

        $this->app->bind(EventStoreInterface::class, function () {
            return new BroadwayEventStore(new EventStore('http://172.16.1.10:2113'));
        });
    }
}
