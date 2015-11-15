<?php
namespace FullRent\Core\Subscription\Events;

use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class SubscriptionStripeCustomerRegistered
 * @package FullRent\Core\Subscription\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionStripeCustomerRegistered implements Event, Serializable
{
    /** @var SubscriptionId */
    private $id;

    /** @var StripeCustomer */
    private $stripCustomer;

    /** @var DateTime */
    private $happened_at;

    /**
     * SubscriptionStripeCustomerRegistered constructor.
     * @param SubscriptionId $id
     * @param StripeCustomer $stripCustomer
     * @param DateTime $happened_at
     */
    public function __construct(SubscriptionId $id, StripeCustomer $stripCustomer, DateTime $happened_at)
    {
        $this->id = $id;
        $this->stripCustomer = $stripCustomer;
        $this->happened_at = $happened_at;
    }

    /**
     * @return SubscriptionId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return StripeCustomer
     */
    public function getStripCustomer()
    {
        return $this->stripCustomer;
    }

    /**
     * @return DateTime
     */
    public function getHappenedAt()
    {
        return $this->happened_at;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'              => (string)$this->id,
            'stripe_customer' => $this->stripCustomer->serialize(),
            'happened_at'     => $this->happened_at->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new SubscriptionId($data['id']),
                          StripeCustomer::deserialize($data['stripe_customer']),
                          DateTime::deserialize($data['happened_at']));
    }
}