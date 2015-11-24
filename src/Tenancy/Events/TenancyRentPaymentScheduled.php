<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class TenancyRentPaymentScheduled
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyRentPaymentScheduled implements Serializable, Event
{
    /** @var TenancyId */
    private $id;

    /** @var RentAmount */
    private $rentAmount;

    /** @var DateTime */
    private $due;

    /** @var DateTime */
    private $created_at;

    /** @var RentPaymentId */
    private $rentPaymentId;


    /**
     * TenancyRentPaymentScheduled constructor.
     * @param TenancyId $id
     * @param RentPaymentId $rentPaymentId
     * @param RentAmount $rentAmount
     * @param DateTime $due
     * @param DateTime $created_at
     */
    public function __construct(
        TenancyId $id,
        RentPaymentId $rentPaymentId,
        RentAmount $rentAmount,
        DateTime $due,
        DateTime $created_at
    ) {
        $this->id = $id;
        $this->rentAmount = $rentAmount;
        $this->due = $due;
        $this->created_at = $created_at;
        $this->rentPaymentId = $rentPaymentId;
    }

    /**
     * @return TenancyId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return RentPaymentId
     */
    public function getRentPaymentId()
    {
        return $this->rentPaymentId;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return DateTime
     */
    public function getDue()
    {
        return $this->due;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tenancy_id'      => (string)$this->id,
            'rent_payment_id' => (string)$this->rentPaymentId,
            'rent_amount'     => $this->rentAmount->serialize(),
            'due_at'          => $this->due->serialize(),
            'created_at'      => $this->created_at->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new TenancyId($data['tenancy_id']),
                          new RentPaymentId($data['rent_payment_id']),
                          RentAmount::deserialize($data['rent_amount']),
                          DateTime::deserialize($data['due_at']),
                          DateTime::deserialize($data['created_at']));
    }
}