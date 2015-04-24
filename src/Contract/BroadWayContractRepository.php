<?php
namespace FullRent\Core\Contract;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class BroadWayContractRepository
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class BroadWayContractRepository extends EventSourcingRepository implements ContractRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Contract::class, new PublicConstructorAggregateFactory());
    }

    public function load($id)
    {
        return parent::load('contract-'.$id);
    }

}