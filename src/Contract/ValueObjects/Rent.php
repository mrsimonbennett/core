<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;

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
     * @param RentAmount $rentAmount
     * @param RentDueDay $rentDueDay
     */
    public function __construct(RentAmount $rentAmount, RentDueDay $rentDueDay)
    {
        $this->rentAmount = $rentAmount;
        $this->rentDueDay = $rentDueDay;
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
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(RentAmount::deserialize($data['rent']), new RentDueDay($data['due']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['rent' => $this->rentAmount->serialize(), 'due' => $this->rentDueDay->getRentDueDay()];
    }
}