<?php namespace FullRent\Core\Application\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BuildApi extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'buildapi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $command = "php vendor/bin/apigen generate -s src/ -d public/apidocs";

        if( ($fp = popen($command, "r")) ) {
            while( !feof($fp) ){
                echo(fread($fp, 1024));
                flush(); // you have to flush buffer
            }
            fclose($fp);
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
