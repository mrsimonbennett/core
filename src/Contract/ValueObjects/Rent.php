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
     * @param RentAmount $rentAmount
     */
    public function __construct(RentAmount $rentAmount)
    {
        $this->rentAmount = $rentAmount;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

}