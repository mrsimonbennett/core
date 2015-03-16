<?php
namespace FullRent\Core\CommandBus;

/**
 * Interface CommandTranslator
 * @package FullRent\Core\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
interface CommandTranslator
{
    /**
     * @param mixed $command
     * @return string
     */
    public function toCommandHandler($command);
}