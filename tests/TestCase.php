<?php

use App\Exceptions\Handler;
use FullRent\Core\CommandBus\CommandBus;
use Illuminate\Contracts\Debug\ExceptionHandler;

/**
 * @property CommandBus bus
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';
		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
		$app->singleton(
			ExceptionHandler::class,
			Handler::class
		);


		$this->bus = $app->make(CommandBus::class);

		return $app;
	}
	public function setUp()
	{
		parent::setUp();

	}

}
