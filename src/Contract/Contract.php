<?php
namespace FullRent\Core\Contract;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Contract\Events\ContractDrafted;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Exceptions\TenantAlreadyJoinedContractException;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;


/**
 * Class Contract
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Contract extends EventSourcedAggregateRoot
{
    /**
     * @var ContractId
     */
    private $contractId;

    /**
     * @var bool
     */
    private $editable;

    /**
     * @var array
     */
    private $tenants = [];


    /**
     * @param ContractId $contractId
     * @param PropertyId $propertyId
     * @param CompanyId $companyId
     * @param LandlordId $landlordId
     * @param Rent $rentDetails
     * @return static
     */
    public static function draftContract(
        ContractId $contractId,
        PropertyId $propertyId,
        CompanyId $companyId,
        LandlordId $landlordId,
        Rent $rentDetails
    ) {
        $contract = new static();
        $contract->apply(new ContractDrafted($contractId,
                                             $propertyId,
                                             $companyId,
                                             $landlordId,
                                             $rentDetails,
                                             DateTime::now()));

        return $contract;

    }


    /**
     * @param TenantId $tenantId
     * @throws TenantAlreadyJoinedContractException
     */
    public function attachTenant(TenantId $tenantId)
    {
        if (in_array((string)$tenantId, $this->tenants)) {
            throw new TenantAlreadyJoinedContractException;
        }
        $this->apply(new TenantJoinedContract($this->contractId, $tenantId, DateTime::now()));
    }


    /**
     * Lock Contract For editing
     */
    public function lock()
    {
        $this->apply(new ContractLocked($this->contractId, DateTime::now()));
    }


    /**
     * @param ContractDrafted $e
     */
    protected function applyContractDrafted(ContractDrafted $e)
    {
        $this->contractId = $e->getContractId();
    }

    /**
     * @param TenantJoinedContract $e
     */
    protected function applyTenantJoinedContract(TenantJoinedContract $e)
    {
        $this->tenants[(string)$e->getTenantId()] = $e->getTenantId();
    }

    /**
     *
     * /**
     * @param ContractLocked $e
     */
    protected function applyContractLocked(ContractLocked $e)
    {
        $this->editable = false;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'contract-' . (string)$this->contractId;
    }
}