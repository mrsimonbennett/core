<?php
namespace FullRent\Core\Property;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class BroadWayPropertyRepository
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class BroadWayPropertyRepository extends EventSourcingRepository implements PropertyRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Property::class, new PublicConstructorAggregateFactory());
    }


}