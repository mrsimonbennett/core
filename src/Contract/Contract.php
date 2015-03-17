<?php
namespace FullRent\Core\Contract;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Contract\Events\ContractWasDrafted;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\Tenant;

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
    protected $contractId;
    /**
     * @var ContractMinimalPeriod
     */
    protected $contractMinimalPeriod;
    /**
     * @var Property
     */
    protected $property;
    /**
     * @var Rent
     */
    protected $rent;
    /**
     * @var Deposit
     */
    protected $deposit;
    /**
     * @var Landlord
     */
    protected $landlord;

    /**
     * @var Tenant[]
     */
    protected $tenants;


    /**
     * @param ContractId $contractId
     * @param Landlord $landlord
     * @param ContractMinimalPeriod $contractMinimalPeriod
     * @param Property $property
     * @param Rent $rent
     * @param Deposit $deposit
     * @return static
     */
    public static function draftContract(
        ContractId $contractId,
        Landlord $landlord,
        ContractMinimalPeriod $contractMinimalPeriod,
        Property $property,
        Rent $rent,
        Deposit $deposit
    ) {
        $contract = new static;
        $contract->apply(new ContractWasDrafted($contractId, $landlord, $contractMinimalPeriod, $property, $rent,
            $deposit));

        return $contract;
    }

    /**
     * @param Tenant $tenant
     */
    public function attachTenant(Tenant $tenant)
    {
        $this->apply(new TenantJoinedContract($this->contractId, $tenant));
    }

    /**
     * @param ContractWasDrafted $contractWasDrafted
     */
    protected function applyContractWasDrafted(ContractWasDrafted $contractWasDrafted)
    {
        $this->contractId = $contractWasDrafted->getContractId();
        $this->landlord = $contractWasDrafted->getLandlord();
        $this->contractMinimalPeriod = $contractWasDrafted->getContractMinimalPeriod();
        $this->property = $contractWasDrafted->getProperty();
        $this->rent = $contractWasDrafted->getRent();
        $this->deposit = $contractWasDrafted->getDeposit();
    }

    /**
     * @param TenantJoinedContract $tenantJoinedContract
     */
    protected function applyTenantJoinedContract(TenantJoinedContract $tenantJoinedContract)
    {
        $this->tenants[(string)$tenantJoinedContract->getTenant()->getTenantId()] = $tenantJoinedContract->getTenant();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string)$this->contractId;
    }
}