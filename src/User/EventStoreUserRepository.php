<?php
namespace FullRent\Core\User;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class EventStoreUserRepository
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class EventStoreUserRepository extends EventSourcingRepository implements UserRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, User::class, new PublicConstructorAggregateFactory());
    }

}