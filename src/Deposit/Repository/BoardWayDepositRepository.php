<?php
namespace FullRent\Core\Deposit\Repository;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;
use FullRent\Core\Deposit\Deposit;

/**
 * Class BoardWayDepositRepository
 * @package FullRent\Core\Deposit\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
final class BoardWayDepositRepository extends EventSourcingRepository implements DepositRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Deposit::class, new PublicConstructorAggregateFactory());
    }

    public function load($id)
    {
        return parent::load('deposit-' . $id);
    }

}