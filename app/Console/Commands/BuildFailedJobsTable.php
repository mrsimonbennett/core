<?php namespace FullRent\Core\Application\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class BuildFailedJobsTable extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'build_failed_jobs_table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the failed jobs table.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        Schema::create('failed_jobs',
            function (Blueprint $table) {
                $table->increments('id');
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->timestamp('failed_at');
            });
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }

}
