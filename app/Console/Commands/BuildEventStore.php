<?php namespace FullRent\Core\Application\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class BuildEventStore extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:buildstore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';
    private $eventStoreTableName = 'eventstore';

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
        Schema::connection('eventstore')->create($this->eventStoreTableName,
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('uuid', 56);
                $table->integer('playhead')->unsigned();
                $table->text('metadata');
                $table->text('payload');
                $table->string('recorded_on', 32);
                $table->text('type');
                $table->unique(['uuid', 'playhead']);
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
