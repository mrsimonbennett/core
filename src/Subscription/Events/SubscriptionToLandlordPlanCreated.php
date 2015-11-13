<?php
namespace FullRent\Core\Subscription\Events;

use FullRent\Core\Subscription\ValueObjects\StripeSubscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use SmoothPhp\Contracts\EventSourcing\Event;

/**
 * Class SubscriptionToLandlordPlanCreated
 * @package FullRent\Core\Subscription\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionToLandlordPlanCreated implements Event
{
    /** @var SubscriptionId */
    private $id;

    /** @var StripeSubscription */
    private $subscription;

    /**
     * SubscriptionToLandlordPlanCreated constructor.
     * @param SubscriptionId $id
     * @param StripeSubscription $subscription
     */
    public function __construct(SubscriptionId $id,StripeSubscription $subscription)
    {
        $this->id = $id;
        $this->subscription = $subscription;
    }

    /**
     * @return StripeSubscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @return SubscriptionId
     */
    public function getId()
    {
        return $this->id;
    }

}