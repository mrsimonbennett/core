<?php namespace FullRent\Core\Application\Console;

use FullRent\Core\Application\Console\Commands\BuildApi;
use FullRent\Core\Application\Console\Commands\BuildEventStore;
use FullRent\Core\Application\Console\Commands\BuildFailedJobsTable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'FullRent\Core\Application\Console\Commands\ReplaceEvents',
        BuildApi::class,
        BuildEventStore::class,
        BuildFailedJobsTable::class

	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();
	}

}
