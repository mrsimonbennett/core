<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class Rent
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Rent implements SerializableInterface
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

    /**
     * @param RentAmount $rentAmount
     * @param RentDueDay $rentDueDay
     * @param DateTime $firstPayment
     * @param bool $fullRentRentCollection
     */
    public function __construct(
        RentAmount $rentAmount,
        RentDueDay $rentDueDay,
        DateTime $firstPayment,
        $fullRentRentCollection = false
    ) {
        $this->rentAmount = $rentAmount;
        $this->rentDueDay = $rentDueDay;
        $this->firstPayment = $firstPayment;
        $this->fullRentRentCollection = $fullRentRentCollection;
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
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(RentAmount::deserialize($data['rent']),
                          new RentDueDay($data['due']),
                          DateTime::deserialize($data['first_payment']),
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
        ];
    }
}