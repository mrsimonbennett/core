<?php
namespace FullRent\Core\Contract;

use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Events\ContractRentInformationDrafted;
use FullRent\Core\Contract\Events\ContractRentPeriodSet;
use FullRent\Core\Contract\Events\ContractSetRequiredDocuments;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Exceptions\TenantAlreadyJoinedContractException;
use FullRent\Core\Contract\ValueObjects\ApplicationId;
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
     * @var DateTime
     */
    private $start;
    /**
     * @var DateTime
     */
    private $end;
    /**
     * @var bool
     */
    private $editable;

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
     * @param DateTime $start
     * @param DateTime $end
     */
    public function setContractPeriod(DateTime $start, DateTime $end)
    {
        $this->apply(new ContractRentPeriodSet($this->contractId, $start, $end, DateTime::now()));
    }

    /**
     * @param Rent $rent
     * @param Deposit $deposit
     */
    public function draftRentInformation(Rent $rent, Deposit $deposit)
    {
        $this->apply(new ContractRentInformationDrafted($this->contractId, $rent, $deposit, DateTime::now()));
    }

    /**
     * @param Document[] $documents
     */
    public function setRequiredDocuments($documents)
    {
        Assertion::allIsInstanceOf($documents, Document::class);

        $this->apply(new ContractSetRequiredDocuments($this->contractId, $documents, DateTime::now()));
    }

    /**
     * Lock Contract For editing
     */
    public function lock()
    {
        $this->apply(new ContractLocked($this->contractId,DateTime::now()));
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

    /**
     * @param TenantJoinedContract $e
     */
    protected function applyTenantJoinedContract(TenantJoinedContract $e)
    {
        $this->tenants[(string)$e->getTenantId()] = $e->getTenantId();
    }

    protected function applyContractRentPeriodSet(ContractRentPeriodSet $e)
    {
        $this->start = $e->getStart();
        $this->end = $e->getEnd();
    }
    /**
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