<?php
namespace FullRent\Core\Company;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

/**
 * Class EventStoreCompanyRepository
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class EventStoreCompanyRepository extends EventSourcingRepository implements CompanyRepository
{
    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     */
    public function __construct(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        parent::__construct($eventStore, $eventBus, Company::class, new PublicConstructorAggregateFactory());
    }
}