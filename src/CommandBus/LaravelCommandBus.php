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
        $this->commandTranslator = $commandTranslator;
    }

    /**
     * @param $command
     * @return void
     */
    public function execute($command)
    {
        $handler = $this->commandTranslator->toCommandHandler($command);

        $this->application->make($handler)->handle($command);
    }
}