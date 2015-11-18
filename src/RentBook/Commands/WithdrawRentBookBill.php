<?php
namespace FullRent\Core\RentBook\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class WithdrawRentBookBill
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class WithdrawRentBookBill extends BaseCommand
{
    private $billId;

    private $preAuthId;

    /**
     * CancelRentBookBill constructor.
     * @param $billId
     * @param $preAuthId
     */
    public function __construct($billId, $preAuthId)
    {
        $this->billId = $billId;
        $this->preAuthId = $preAuthId;

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
    public function getPreAuthId()
    {
        return $this->preAuthId;
    }
}