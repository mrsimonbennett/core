<?php
namespace FullRent\Core\RentBook;

use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\Services\DirectDebit\Bill;
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
     * @var Bill
     */
    private $bill;

    /**
     * @var string
     */
    private $gocardlessBillId;

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

    /**
     * @param Bill $bill
     */
    public function setBill(Bill $bill)
    {
        $this->gocardlessBillId = $bill->getId();
        $this->bill = $bill;
    }

    /**
     * @return Bill
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * @return string
     */
    public function getGocardlessBillId()
    {
        return $this->gocardlessBillId;
    }

}