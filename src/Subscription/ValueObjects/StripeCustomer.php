<?php
namespace FullRent\Core\Subscription\ValueObjects;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class StripeCustomer
 * @package FullRent\Core\Subscription\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class StripeCustomer implements Serializable
{
    /**
     * @var string
     */
    private $stripeCustomerId;

    /** @var DateTime */
    private $createdAt;

    /**
     * StripeCustomer constructor.
     * @param string $stripeCustomerId
     * @param DateTime $createdAt
     */
    public function __construct($stripeCustomerId, DateTime $createdAt)
    {
        $this->stripeCustomerId = $stripeCustomerId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getStripeCustomerId()
    {
        return $this->stripeCustomerId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['stripe_customer_id' => $this->stripeCustomerId, 'created_at' => $this->createdAt->serialize()];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['stripe_customer_id'], DateTime::deserialize($data['created_at']));
    }
}