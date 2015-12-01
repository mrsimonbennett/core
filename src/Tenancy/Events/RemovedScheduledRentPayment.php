<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class RemovedScheduledRentPayment
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RemovedScheduledRentPayment implements Serializable, Event
{
    /** @var TenancyId */
    private $tenancyId;

    /** @var RentPaymentId */
    private $rentPaymentId;

    /** @var DateTime */
    private $removedAt;

    /**
     * RemovedScheduledRentPayment constructor.
     * @param TenancyId $tenancyId
     * @param RentPaymentId $rentPaymentId
     * @param DateTime $removedAt
     */
    public function __construct(TenancyId $tenancyId, RentPaymentId $rentPaymentId, DateTime $removedAt)
    {
        $this->tenancyId = $tenancyId;
        $this->rentPaymentId = $rentPaymentId;
        $this->removedAt = $removedAt;
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return RentPaymentId
     */
    public function getRentPaymentId()
    {
        return $this->rentPaymentId;
    }

    /**
     * @return DateTime
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tenancy_id'      => (string)$this->tenancyId,
            'rent_payment_id' => (string)$this->rentPaymentId,
            'removed_at'      => $this->removedAt->serialize(),
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
                          DateTime::deserialize($data['removed_at']));
    }
}