<?php
namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ScheduleTenancyRentPayment
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ScheduleTenancyRentPayment extends BaseCommand
{
    private $tenancyId;

    private $rentAmount;

    private $dueOn;

    /** @var */
    private $rentPaymentId;

    /**
     * ScheduleTenancyRentPayment constructor.
     * @param $rentPaymentId
     * @param $tenancyId
     * @param $rentAmount
     * @param $dueOn
     */
    public function __construct($rentPaymentId,  $tenancyId, $rentAmount, $dueOn)
    {
        $this->tenancyId = $tenancyId;
        $this->rentAmount = $rentAmount;
        $this->dueOn = $dueOn;
        $this->rentPaymentId = $rentPaymentId;
    }

    /**
     * @return mixed
     */
    public function getRentPaymentId()
    {
        return $this->rentPaymentId;
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
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return mixed
     */
    public function getDueOn()
    {
        return $this->dueOn;
    }

}