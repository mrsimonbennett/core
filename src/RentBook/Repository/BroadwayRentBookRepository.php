<?php
namespace FullRent\Core\RentBook\Repository;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use FullRent\Core\RentBook\RentBook;

/**
 * Class BroadwayRentBookRepository
 * @package FullRent\Core\RentBook\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
final class BroadwayRentBookRepository extends EventSourcingRepository implements RentBookRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, RentBook::class, new PublicConstructorAggregateFactory());
    }

    /**
     * @param mixed $id
     * @return \Broadway\Domain\AggregateRoot|\Broadway\EventSourcing\EventSourcedAggregateRoot
     */
    public function load($id)
    {
        return parent::load('rent-book' . $id);
    }
}