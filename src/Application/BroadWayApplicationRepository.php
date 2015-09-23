<?php
namespace FullRent\Core\Application;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class BoardWayApplicationRepository
 * @package FullRent\Core\Application
 * @author Simon Bennett <simon@bennett.im>
 */
final class BroadWayApplicationRepository extends EventSourcingRepository implements ApplicationRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Application::class, new PublicConstructorAggregateFactory());
    }

    /**
     * @param mixed $id
     * @return \Broadway\Domain\AggregateRoot|\Broadway\EventSourcing\EventSourcedAggregateRoot
     */
    public function load($id)
    {
        return parent::load('application-'. $id);
    }
}