<?php
namespace FullRent\Core\Subscription\Events;

use FullRent\Core\Subscription\ValueObjects\StripeSubscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class SubscriptionToLandlordPlanCreated
 * @package FullRent\Core\Subscription\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionToLandlordPlanCreated implements Event, Serializable
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
    public function __construct(SubscriptionId $id, StripeSubscription $subscription)
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

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'           => (string)$this->id,
            'subscription' => $this->subscription->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new SubscriptionId($data['id']),
                          StripeSubscription::deserialize($data['subscription']));
    }
}