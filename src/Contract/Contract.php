<?php
namespace FullRent\Core\Contract;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Exceptions\TenantAlreadyJoinedContractException;
use FullRent\Core\Contract\ValueObjects\ApplicationId;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
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
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var LandlordId
     */
    private $landlordId;
    /**
     * @var DateTime
     */
    private $draftedAt;
    /**
     * @var TenantId[]
     */
    private $tenants = [];

    /**
     * @param ContractId $contractId
     * @param ApplicationId $applicationId
     * @param PropertyId $propertyId
     * @param LandlordId $landlordId
     * @param CompanyId $companyId
     * @param DateTime $draftedAt
     * @return static
     */
    public static function draftFromApplication(
        ContractId $contractId,
        ApplicationId $applicationId,
        PropertyId $propertyId,
        LandlordId $landlordId,
        CompanyId $companyId,
        DateTime $draftedAt = null
    ) {
        if (is_null($draftedAt)) {
            $draftedAt = DateTime::now();
        }

        $contract = new static();
        $contract->apply(new ContractDraftedFromApplication($contractId,
                                                            $applicationId,
                                                            $propertyId,
                                                            $landlordId,
                                                            $companyId,
                                                            $draftedAt));

        return $contract;
    }

    public function attachTenant(TenantId $tenantId)
    {
        if (in_array((string)$tenantId, $this->tenants)) {
            throw new TenantAlreadyJoinedContractException;
        }
        $this->apply(new TenantJoinedContract($this->contractId, $tenantId, DateTime::now()));
    }

    /**
     * @param ContractDraftedFromApplication $e
     */
    protected function applyContractDraftedFromApplication(ContractDraftedFromApplication $e)
    {
        $this->contractId = $e->getContractId();
        $this->applicationId = $e->getApplicationId();
        $this->propertyId = $e->getPropertyId();
        $this->landlordId = $e->getLandlordId();
        $this->draftedAt = $e->getDraftedAt();
    }

    protected function applyTenantJoinedContract(TenantJoinedContract $e)
    {
        $this->tenants[(string)$e->getTenantId()] = $e->getTenantId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'contract-' . (string)$this->contractId;
    }
}