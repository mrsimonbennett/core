<?php
namespace FullRent\Core\Subscription\ValueObjects;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class StripeSubscription
 * @package FullRent\Core\Subscription\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class StripeSubscription implements Serializable
{
    /** @var string */
    private $subscriptionId;

    /** @var string */
    private $customerId;

    /** @var DateTime */
    private $periodStart;

    /** @var DateTime */
    private $periodEnd;

    /**
     * StripeSubscription constructor.
     * @param string $subscriptionId
     * @param string $customerId
     * @param DateTime $periodStart
     * @param DateTime $periodEnd
     */
    public function __construct($subscriptionId, $customerId, DateTime $periodStart, DateTime $periodEnd)
    {
        $this->subscriptionId = $subscriptionId;
        $this->customerId = $customerId;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @return DateTime
     */
    public function getPeriodStart()
    {
        return $this->periodStart;
    }

    /**
     * @return DateTime
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'subscription_id' => $this->subscriptionId,
            'customer_id'     => $this->customerId,
            'period_start'    => $this->periodStart->serialize(),
            'period_end'      => $this->periodEnd->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['subscription_id'],
                          $data['customer_id'],
                          DateTime::deserialize($data['period_start']),
                          DateTime::deserialize($data['period_end']));
    }
}