<?php namespace FullRent\Core\Application\Console\Commands;

use EventStore\EventStore;
use EventStore\StreamFeed\EntryEmbedMode;
use Illuminate\Console\Command;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ReplaceEvents extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:replay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replay aggregates events.';
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Create a new command instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $es = new EventStore('http://172.16.1.10:2113');
        $stream = $es->openStreamFeed('$ce-' . $this->argument('type'), EntryEmbedMode::RICH());
        foreach ($stream->getEntries() as $entry) {


            $event = $es->readEvent($entry->getEventUrl());
            $data = $event->getData();
            unset($data['broadway_recorded_on']);
            $this->dispatcher->fire(str_replace('\\','.',$entry->getJson()['eventType']),
                (call_user_func(
                    [
                        $entry->getJson()['eventType'],
                        'deserialize'
                    ],
                    $data
                )));
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['type', InputArgument::REQUIRED, 'Type (user,contract,property,company).'],
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
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
