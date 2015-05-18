<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class SetContractRentInfomation
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractRentInformation
{

    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $rent;
    /**
     * @var string
     */
    private $rentPayable;
    /**
     * @var string
     */
    private $firstRentPayment;
    /**
     * @var string
     */
    private $deposit;
    /**
     * @var string
     */
    private $depositDue;
    /**
     * @var bool
     */
    private $fullRentDepositCollection;
    /**
     * @var bool
     */
    private $fullRentRentCollection;

    /**
     * @param string $contractId
     * @param string $rent
     * @param string $rentPayable
     * @param string $firstRentPayment
     * @param bool $fullRentRentCollection
     * @param string$deposit
     * @param string $depositDue
     * @param bool $fullRentDepositCollection
     */
    public function __construct(
        $contractId,
        $rent,
        $rentPayable,
        $firstRentPayment,
        $fullRentRentCollection,
        $deposit,
        $depositDue,
        $fullRentDepositCollection
    ) {
        $this->contractId = $contractId;
        $this->rent = $rent;
        $this->rentPayable = $rentPayable;
        $this->firstRentPayment = $firstRentPayment;
        $this->deposit = $deposit;
        $this->depositDue = $depositDue;
        $this->fullRentDepositCollection = $fullRentDepositCollection;
        $this->fullRentRentCollection = $fullRentRentCollection;
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
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @return string
     */
    public function getRentPayable()
    {
        return $this->rentPayable;
    }

    /**
     * @return string
     */
    public function getFirstRentPayment()
    {
        return $this->firstRentPayment;
    }

    /**
     * @return boolean
     */
    public function isFullRentRentCollection()
    {
        return $this->fullRentRentCollection;
    }

    /**
     * @return string
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * @return string
     */
    public function getDepositDue()
    {
        return $this->depositDue;
    }

    /**
     * @return bool
     */
    public function getFullRentDepositCollection()
    {
        return $this->fullRentDepositCollection;
    }
}