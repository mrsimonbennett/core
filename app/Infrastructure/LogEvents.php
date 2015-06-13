<?php
namespace FullRent\Core\Application\Infrastructure;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use Illuminate\Log\Writer;

/**
 * Class LogEvents
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class LogEvents implements EventListenerInterface
{
    /**
     * @var Writer
     */
    private $writer;


    /**
     * @param Writer $writer
     */
    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
    }
    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage)
    {
        $name = explode('.',$domainMessage->getType());

        $name = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', end($name));
        $this->writer->debug(trim(ucwords($name)) . " ({$domainMessage->getType()})");
    }
}