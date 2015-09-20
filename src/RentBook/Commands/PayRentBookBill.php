<?php
namespace FullRent\Core\RentBook\Commands;

/**
 * Class PayRentBookBill
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class PayRentBookBill
{
    private $preAuthId;

    private $billId;

    private $paidAtString;

    /**
     * CreatingRentBookBill constructor.
     * @param $preAuthId
     * @param $billId
     */
    public function __construct($preAuthId, $billId, $paidAtString)
    {
        $this->preAuthId = $preAuthId;
        $this->billId = $billId;
        $this->paidAtString = $paidAtString;
    }

    /**
     * @return mixed
     */
    public function getPreAuthId()
    {
        return $this->preAuthId;
    }

    /**
     * @return mixed
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * @return mixed
     */
    public function getPaidAtString()
    {
        return $this->paidAtString;
    }

}