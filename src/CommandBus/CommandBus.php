<?php
namespace FullRent\Core\CommandBus;

/**
 * Interface CommandBus
 * @package FullRent\Core\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface CommandBus
{
    /**
     * @param $command
     * @return void
     */
    public function execute($command);
}