<?php
namespace FullRent\Core\CommandBus;

interface CommandBus
{
    /**
     * @param $command
     * @return void
     */
    public function execute($command);
}