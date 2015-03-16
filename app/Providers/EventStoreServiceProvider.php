<?php namespace App\Providers;

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

		$this->app->bind(EventStoreInterface::class, function ($app) {
			$es = new EventStore('http://127.0.0.1:2113');

			return new BroadwayEventStore($es);
		});

	}

}
