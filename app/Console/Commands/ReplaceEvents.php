<?php namespace FullRent\Core\Application\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
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
     * @var Connection
     */
    private $db;

    /**
     * Create a new command instance.
     *
     * @param Dispatcher $dispatcher
     * @param DatabaseManager $db
     */
    public function __construct(Dispatcher $dispatcher, DatabaseManager $db)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->line('Rebuild Projections and system from the Event Store');

        $this->line('Loading events from store');
        $this->line((memory_get_peak_usage(true) / 1024 / 1024) . " MiB");

        $allEvents = $this->db->connection('eventstore')->table('eventstore')->get();
        $eventCount = count($allEvents);
        $this->line("Found {$eventCount} to replay");
        // $this->output->progressStart(count($allEvents));

        foreach ($allEvents as $eventRow) {
            $payload = json_decode($eventRow->payload, true)['payload'];
            $this->dispatcher->fire($eventRow->type,
                (call_user_func(
                    [
                        str_replace('.', '\\', $eventRow->type),
                        'deserialize'
                    ],
                    $payload
                )));
            $this->line($eventRow->type);
            //$this->output->progressAdvance();

        }

        // $this->output->progressFinish();

        $this->line((memory_get_peak_usage(true) / 1024 / 1024) . " MiB");

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
