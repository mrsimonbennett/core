<?php namespace FullRent\Core\Application\Providers;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventHandling\SimpleEventBus;
use Broadway\EventStore\EventStoreInterface;
use EventStore\Broadway\BroadwayEventStore;
use EventStore\EventStore;
use Illuminate\Support\ServiceProvider;

class EventStoreServiceProvider extends ServiceProvider {

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
		$this->app->bind(EventBusInterface::class, SimpleEventBus::class);

		$this->app->bind(EventStoreInterface::class, function () {
			return new BroadwayEventStore(new EventStore('http://172.16.1.10:2113'));
		});
	}
}
