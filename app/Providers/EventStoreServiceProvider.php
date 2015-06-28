<?php namespace FullRent\Core\Application\Providers;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use Broadway\Serializer\SerializerInterface;
use Broadway\Serializer\SimpleInterfaceSerializer;
use FullRent\Core\Application\Infrastructure\BroadWayToLaravelEvents;
use FullRent\Core\Application\Infrastructure\LogEvents;
use FullRent\Core\Application\Infrastructure\SlackNotifications;
use FullRent\Core\Infrastructure\EventStore\LaravelEventStore;
use Illuminate\Support\ServiceProvider;
use Rhumsaa\Uuid\Console\Exception;

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
        $this->app->bind(SerializerInterface::class, SimpleInterfaceSerializer::class);

        $this->app->singleton(EventBusInterface::class, SimpleEventBus::class);

        /** @var EventBusInterface $eventBus */
        $eventBus = $this->app->make(EventBusInterface::class);
        $eventBus->subscribe($this->app->make(LogEvents::class));
        $eventBus->subscribe($this->app->make(BroadWayToLaravelEvents::class));
        //$eventBus->subscribe($this->app->make(SlackNotifications::class));

        $this->app->bind(EventStoreInterface::class, LaravelEventStore::class);
    }
}
