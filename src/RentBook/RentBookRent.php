<?php
namespace FullRent\Core\RentBook;

use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookRent
 * @package FullRent\Core\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookRent
{
    /**
     * @var RentBookRentId
     */
    private $rentBookRentId;
    /**
     * @var DateTime
     */
    private $paymentDue;
    /**
     * @var RentAmount
     */
    private $rentAmount;

    /**
     * @param RentBookRentId $rentBookRentId
     * @param DateTime $paymentDue
     * @param RentAmount $rentAmount
     */
    public function __construct(RentBookRentId $rentBookRentId, DateTime $paymentDue, RentAmount $rentAmount)
    {
        $this->rentBookRentId = $rentBookRentId;
        $this->paymentDue = $paymentDue;
        $this->rentAmount = $rentAmount;
    }

    /**
     * @return RentBookRentId
     */
    public function getRentBookRentId()
    {
        return $this->rentBookRentId;
    }

    /**
     * @return DateTime
     */
    public function getPaymentDue()
    {
        return $this->paymentDue;
    }

    /**
     * @return RentAmount
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

}