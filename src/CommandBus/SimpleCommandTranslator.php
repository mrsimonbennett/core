<?php
namespace FullRent\Core\CommandBus;

/**
 * Class SimpleCommandTranslator
 * @package FullRent\Core\CommandBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class SimpleCommandTranslator implements CommandTranslator
{
    /**
     * @param $command
     * @return string
     */
    public function toCommandHandler($command)
    {
        return get_class($command) . 'Handler';
    }
}