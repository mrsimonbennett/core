<?php
namespace FullRent\Core\Deposit\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Deposit\ValueObjects\ContractId;
use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Deposit\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DepositSetUp
 * @package FullRent\Core\Deposit\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositSetUp implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var DepositId
     */
    private $depositId;
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var TenantId
     */
    private $tenantId;
    /**
     * @var DepositAmount
     */
    private $depositAmount;
    /**
     * @var DateTime
     */
    private $depositDue;
    /**
     * @var bool
     */
    private $fullrentCollection;
    /**
     * @var DateTime
     */
    private $setupAt;

    /**
     * @param DepositId $depositId
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param DepositAmount $depositAmount
     * @param DateTime $depositDue
     * @param bool $fullrentCollection
     * @param DateTime $setupAt
     */
    public function __construct(
        DepositId $depositId,
        ContractId $contractId,
        TenantId $tenantId,
        DepositAmount $depositAmount,
        DateTime $depositDue,
        $fullrentCollection,
        DateTime $setupAt
    ) {
        $this->depositId = $depositId;
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->depositAmount = $depositAmount;
        $this->depositDue = $depositDue;
        $this->fullrentCollection = $fullrentCollection;
        $this->setupAt = $setupAt;
    }

    /**
     * @return DepositId
     */
    public function getDepositId()
    {
        return $this->depositId;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return DepositAmount
     */
    public function getDepositAmount()
    {
        return $this->depositAmount;
    }

    /**
     * @return DateTime
     */
    public function getDepositDue()
    {
        return $this->depositDue;
    }

    /**
     * @return bool
     */
    public function getFullrentCollection()
    {
        return $this->fullrentCollection;
    }

    /**
     * @return DateTime
     */
    public function getSetupAt()
    {
        return $this->setupAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new DepositId($data['deposit_id']),
                          new ContractId($data['contract_id']),
                          new TenantId($data['tenant_id']),
                          DepositAmount::deserialize($data['deposit_amount']),
                          DateTime::deserialize($data['deposit_due']),
                          $data['fullrent_collection'],
                          DateTime::deserialize($data['setup_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'deposit_id'          => (string)$this->depositId,
            'contract_id'         => (string)$this->contractId,
            'tenant_id'           => (string)$this->tenantId,
            'deposit_amount'      => $this->depositAmount->serialize(),
            'deposit_due'         => $this->depositDue->serialize(),
            'fullrent_collection' => $this->fullrentCollection,
            'setup_at'            => $this->setupAt->serialize(),
        ];
    }
}