<?php
namespace FullRent\Core\Contract\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class Rent
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Rent implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var RentAmount
     */
    private $rentAmount;

    /**
     * @var RentDueDay
     */
    private $rentDueDay;

    /**
     * @var DateTime
     */
    private $firstPayment;

    /**
     * @var bool
     */
    private $fullRentRentCollection;

    /** @var DateTime */
    private $start;

    /** @var DateTime */
    private $end;

    /**
     * @param RentAmount $rentAmount
     * @param RentDueDay $rentDueDay
     * @param DateTime $firstPayment
     * @param DateTime $start
     * @param DateTime $end
     * @param bool $fullRentRentCollection
     */
    public function __construct(
        RentAmount $rentAmount,
        RentDueDay $rentDueDay,
        DateTime $firstPayment,
        DateTime $start,
        DateTime $end,
        $fullRentRentCollection = false
    ) {
        $this->rentAmount = $rentAmount;
        $this->rentDueDay = $rentDueDay;
        $this->firstPayment = $firstPayment;
        $this->fullRentRentCollection = $fullRentRentCollection;
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return RentDueDay
     */
    public function getRentDueDay()
    {
        return $this->rentDueDay;
    }

    /**
     * @return DateTime
     */
    public function getFirstPayment()
    {
        return $this->firstPayment;
    }

    /**
     * @return boolean
     */
    public function isFullRentRentCollection()
    {
        return $this->fullRentRentCollection;
    }

    /**
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }


    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(RentAmount::deserialize($data['rent']),
                          new RentDueDay($data['due']),
                          DateTime::deserialize($data['first_payment']),
                          DateTime::deserialize($data['start']),
                          DateTime::deserialize($data['end']),
                          isset($data['fullrent_collection']) ? $data['fullrent_collection'] : false
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent'                => $this->rentAmount->serialize(),
            'due'                 => $this->rentDueDay->getRentDueDay(),
            'first_payment'       => $this->firstPayment->serialize(),
            'fullrent_collection' => $this->fullRentRentCollection,
            'start'               => $this->start->serialize(),
            'end'                 => $this->end->serialize(),
        ];
    }
}