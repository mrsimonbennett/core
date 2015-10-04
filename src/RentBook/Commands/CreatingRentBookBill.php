<?php
namespace FullRent\Core\RentBook\Commands;

/**
 * Class CreatingRentBookBill
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CreatingRentBookBill
{
    private $preAuthId;

    private $billId;

    /**
     * CreatingRentBookBill constructor.
     * @param $preAuthId
     * @param $billId
     */
    public function __construct($preAuthId, $billId)
    {
        $this->preAuthId = $preAuthId;
        $this->billId = $billId;
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

}