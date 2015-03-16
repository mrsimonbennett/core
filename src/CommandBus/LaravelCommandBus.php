<?php
namespace FullRent\Core\CommandBus;

use Illuminate\Contracts\Foundation\Application;

final class LaravelCommandBus implements CommandBus
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var CommandTranslator
     */
    private $commandTranslator;

    /**
     * @param CommandTranslator $commandTranslator
     * @param Application $application
     */
    public function __construct(CommandTranslator $commandTranslator, Application $application)
    {
        $this->application = $application;
        $this->commandTranslater = $commandTranslator;
    }

    /**
     * @param $command
     * @return void
     */
    public function execute($command)
    {
        $handler = $this->commandTranslater->toCommandHandler($command);

        return $this->application->make($handler)->handle($command);
    }
}