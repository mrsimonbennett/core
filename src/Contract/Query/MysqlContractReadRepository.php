<?php
namespace FullRent\Core\Contract\Query;

use FullRent\Core\Contract\Exceptions\ContractNotFound;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;

/**
 * Class MysqlContractReadRepository
 * @package FullRent\Core\Contract\Query
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlContractReadRepository extends BaseMysqlSubscriber implements ContractReadRepository
{

    /**
     * @param PropertyId $propertyId
     * @return \stdClass
     */
    public function getByProperty(PropertyId $propertyId)
    {
        $contracts = $this->db->table('contracts')
                              ->where('property_id', $propertyId)
                              ->get();

        foreach ($contracts as $contract) {
            $contract->tenants = $this->db->table('contract_tenants')
                                          ->where('contract_id', $contract->id)
                                          ->join('users', 'users.id', '=', 'contract_tenants.tenant_id')
                                          ->get();
        }

        return $contracts;
    }

    /**
     * @param ContractId $contractId
     * @return \stdClass
     * @throws ContractNotFound
     */
    public function getById(ContractId $contractId)
    {
        $contract = $this->db->table('contracts')->where('id', $contractId)->first();
        if ($contract == null) {
            throw new ContractNotFound();
        }
        $contract->tenants = $this->db->table('contract_tenants')
                                      ->where('contract_id', $contract->id)
                                      ->join('users', 'users.id', '=', 'contract_tenants.tenant_id')
                                      ->get();

        return $contract;

    }

    /**
     * @param TenantId $tenantId
     * @return \stdClass
     */
    public function getByTenantId(TenantId $tenantId)
    {
        $contracts = $this->db->table('contract_tenants')
                              ->where('tenant_id', $tenantId)
                              ->join('contracts', 'contracts.id', '=', 'contract_tenants.contract_id')
                              ->get();
        foreach ($contracts as $contract) {
            $contract->property = $this->db->table('properties')->where('id', $contract->property_id)->first();
        }

        return $contracts;
    }
}