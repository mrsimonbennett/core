<?php
namespace FullRent\Core\Services\DirectDebit;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\ValueObjects\Money\Money;

/**
 * Class Bill
 * @package FullRent\Core\Services\DirectDebit
 * @author Simon Bennett <simon@bennett.im>
 */
final class Bill implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var Money
     */
    private $amount;
    /**
     * @var Money
     */
    private $gocardlessFees;
    /**
     * @var Money
     */
    private $fullrentFees;
    /**
     * @var Money
     */
    private $landlordReceive;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $status;
    /**
     * @var DateTime
     */
    private $chargeCustomerAt;

    /**
     * @param string $id
     * @param Money $amount
     * @param Money $gocardlessFees
     * @param Money $fullrentFees
     * @param Money $landlordReceive
     * @param string $name
     * @param string $status
     * @param DateTime $chargeCustomerAt
     */
    public function __construct(
        $id,
        Money $amount,
        Money $gocardlessFees,
        Money $fullrentFees,
        Money $landlordReceive,
        $name,
        $status,
        DateTime $chargeCustomerAt
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->gocardlessFees = $gocardlessFees;
        $this->fullrentFees = $fullrentFees;
        $this->landlordReceive = $landlordReceive;
        $this->name = $name;
        $this->status = $status;
        $this->chargeCustomerAt = $chargeCustomerAt;
    }

    public static function fromGoCardless($bill)
    {
        return new static($bill->id,
                          Money::fromPounds($bill->amount),
                          Money::fromPounds($bill->gocardless_fees),
                          Money::fromPounds($bill->partner_fees),
                          Money::fromPounds($bill->amount_minus_fees),
                          $bill->name,
                          $bill->status,
                          new DateTime($bill->charge_customer_at));

    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return Money
     */
    public function getGocardlessFees()
    {
        return $this->gocardlessFees;
    }

    /**
     * @return Money
     */
    public function getFullrentFees()
    {
        return $this->fullrentFees;
    }

    /**
     * @return Money
     */
    public function getLandlordReceive()
    {
        return $this->landlordReceive;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getChargeCustomerAt()
    {
        return $this->chargeCustomerAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            $data['id'],
            Money::deserialize($data['amount']),
            Money::deserialize($data['gocardless_fee']),
            Money::deserialize($data['fullrent_fee']),
            Money::deserialize($data['landlord_receives']),
            $data['name'],
            $data['status'],
            DateTime::deserialize($data['charge_customer_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'                 => $this->id,
            'amount'             => $this->amount->serialize(),
            'gocardless_fee'     => $this->gocardlessFees->serialize(),
            'fullrent_fee'       => $this->fullrentFees->serialize(),
            'landlord_receives'  => $this->landlordReceive->serialize(),
            'name'               => $this->name,
            'status'             => $this->status,
            'charge_customer_at' => $this->chargeCustomerAt->serialize(),
        ];
    }
}