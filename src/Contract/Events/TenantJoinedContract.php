<?php
namespace FullRent\Core\Contract\Events;

use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\Tenant;

/**
 * Class TenantJoinedContract
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantJoinedContract
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var Tenant
     */
    private $tenant;

    /**
     * @param ContractId $contractId
     * @param Tenant $tenant
     */
    public function __construct(ContractId $contractId, Tenant $tenant)
    {
        $this->contractId = $contractId;
        $this->tenant = $tenant;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return Tenant
     */
    public function getTenant()
    {
        return $this->tenant;
    }

}