<?php
namespace FullRent\Core\Subscription\Repository;

use FullRent\Core\Subscription\Subscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

/**
 * Interface SubscriptionRepository
 * @package FullRent\Core\Subscription\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
interface SubscriptionRepository
{
    /**
     * @param SubscriptionId $id
     * @return Subscription
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}