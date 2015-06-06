<?php
namespace FullRent\Core\Deposit\Commands;

/**
 * Class SetupDeposit
 * @package FullRent\Core\Deposit\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetupDeposit
{
    /**
     * @var string
     */
    private $depositId;
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
    private $depositAmountPounds;
    /**
     * @var string
     */
    private $depositDue;
    /**
     * @var bool
     */
    private $fullrentDepositCollection;

    /**
     * @param string $depositId
     * @param string $contractId
     * @param string $tenantId
     * @param string $depositAmountPounds
     * @param string $depositDue
     * @param bool $fullrentDepositCollection
     */
    public function __construct(
        $depositId,
        $contractId,
        $tenantId,
        $depositAmountPounds,
        $depositDue,
        $fullrentDepositCollection
    ) {
        $this->depositId = $depositId;
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->depositAmountPounds = $depositAmountPounds;
        $this->depositDue = $depositDue;
        $this->fullrentDepositCollection = $fullrentDepositCollection;
    }

    /**
     * @return string
     */
    public function getDepositId()
    {
        return $this->depositId;
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
    public function getDepositAmountPounds()
    {
        return $this->depositAmountPounds;
    }

    /**
     * @return string
     */
    public function getDepositDue()
    {
        return $this->depositDue;
    }

    /**
     * @return boolean
     */
    public function isFullrentDepositCollection()
    {
        return $this->fullrentDepositCollection;
    }

}