<?php namespace FullRent\Core\Application\Console\Commands;

use EventStore\EventStore;
use EventStore\Exception\StreamNotFoundException;
use EventStore\StreamFeed\EntryEmbedMode;
use EventStore\StreamFeed\LinkRelation;
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

        $this->line('Running: '.ucfirst($this->argument('type')));
        try {
            $feed = $es->openStreamFeed('$ce-' . $this->argument('type'), EntryEmbedMode::RICH());
        } catch (StreamNotFoundException $ex) {
            $this->error('Stream Not Found');

            return;
        }
        $feed = $es
            ->navigateStreamFeed(
                $feed,
                LinkRelation::FIRST()
            );

        $rel = LinkRelation::NEXT();

        $messages = [];
        $i = 0;
        while ($feed !== null) {
            foreach ($feed->getEntries() as $entry) {
                $event = $es->readEvent($entry->getEventUrl());
                $data = $event->getData();
                $messages[] = [
                    'eventType'  => $entry->getJson()['eventType'],
                    'data'       => $data,
                    'eventClass' => str_replace('\\', '.', $entry->getJson()['eventType'])
                ];

            }
            $feed = $es
                ->navigateStreamFeed(
                    $feed,
                    $rel
                );
        }
        foreach (array_reverse($messages) as $message) {
            $this->line($message['eventType']);
            $this->dispatcher->fire($message['eventClass'],
                (call_user_func(
                    [
                        $message['eventType'],
                        'deserialize'
                    ],
                    $message['data']
                )));
        }
        $this->line("");

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected
    function getArguments()
    {
        return [
            ['type', InputArgument::OPTIONAL, 'Type (user,contract,property,company).'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected
    function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
