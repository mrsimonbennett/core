<?php
namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class AmendScheduledTenancyRentPayment
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AmendScheduledTenancyRentPayment extends BaseCommand
{
    private $tenancyId;

    private $paymentId;

    private $newRentAmount;

    private $newRentDue;

    /**
     * AmendScheduledTenancyRentPayment constructor.
     * @param $tenancyId
     * @param $paymentId
     * @param $newRentAmount
     * @param $newRentDue
     */
    public function __construct($tenancyId, $paymentId, $newRentAmount, $newRentDue)
    {
        $this->tenancyId = $tenancyId;
        $this->paymentId = $paymentId;
        $this->newRentAmount = $newRentAmount;
        $this->newRentDue = $newRentDue;
    }

    /**
     * @return mixed
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return mixed
     */
    public function getNewRentAmount()
    {
        return $this->newRentAmount;
    }

    /**
     * @return mixed
     */
    public function getNewRentDue()
    {
        return $this->newRentDue;
    }

}