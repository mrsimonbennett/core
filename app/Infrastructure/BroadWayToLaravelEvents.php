<?php
namespace FullRent\Core\Application\Infrastructure;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class BroadWayToLaravelEvents
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class BroadWayToLaravelEvents implements EventListenerInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param DomainMessage $domainMessage
     */
    public function handle(DomainMessage $domainMessage)
    {
        \Queue::push(LaravelQueueHandler::class,['type' => $domainMessage->getType(),'job' => $domainMessage->getPayload()->serialize()]);
    }
}