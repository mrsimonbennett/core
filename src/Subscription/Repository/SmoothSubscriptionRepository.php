<?php
namespace FullRent\Core\Subscription\Repository;

use FullRent\Core\Subscription\Subscription;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothSubscriptionRepository
 * @package FullRent\Core\Subscription\Repository
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothSubscriptionRepository extends EventSourcedRepository implements SubscriptionRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'subscription-';
    }

    /**
     * @return string
     */
    protected function getAggregateType()
    {
        return Subscription::class;
    }
}