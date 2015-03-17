<?php
namespace FullRent\Core\Contract\ValueObjects;


/**
 * Class Rent
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Rent
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

}