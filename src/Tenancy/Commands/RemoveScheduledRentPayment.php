<?php
namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RemoveScheduledRentPayment
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RemoveScheduledRentPayment extends BaseCommand
{
    private $tenancyId;

    private $paymentId;

    /**
     * RemoveScheduledRentPayment constructor.
     * @param $tenancyId
     * @param $paymentId
     */
    public function __construct($tenancyId, $paymentId)
    {
        $this->tenancyId = $tenancyId;
        $this->paymentId = $paymentId;
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

}