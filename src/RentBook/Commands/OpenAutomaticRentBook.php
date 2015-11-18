<?php
namespace FullRent\Core\RentBook\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class OpenAutomaticRentBook
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class OpenAutomaticRentBook extends BaseCommand
{
    /**
     * @var string
     */
    private $rentBookId;
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $tenantId;
    /**
     * @var string
     */
    private $rentInPounds;
    /**
     * @var \string[]
     */
    private $paymentDates;

    /**
     * @param string $rentBookId
     * @param string $contractId
     * @param string $tenantId
     * @param string $rentInPounds
     * @param string[] $paymentDates
     */
    public function __construct($rentBookId, $contractId, $tenantId, $rentInPounds, $paymentDates)
    {
        $this->rentBookId = $rentBookId;
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->rentInPounds = $rentInPounds;
        $this->paymentDates = $paymentDates;
        parent::__construct();

    }

    /**
     * @return string
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return string
     */
    public function getRentInPounds()
    {
        return $this->rentInPounds;
    }

    /**
     * @return \string[]
     */
    public function getPaymentDates()
    {
        return $this->paymentDates;
    }

}