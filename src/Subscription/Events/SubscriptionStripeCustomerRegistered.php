<?php
namespace FullRent\Core\Subscription\Events;

use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;

/**
 * Class SubscriptionStripeCustomerRegistered
 * @package FullRent\Core\Subscription\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionStripeCustomerRegistered implements Event
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

}