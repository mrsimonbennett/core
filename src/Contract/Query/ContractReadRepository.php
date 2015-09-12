<?php
namespace FullRent\Core\Contract\Query;

use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\TenantId;

/**
 * Interface ContractReadRepository
 * @package FullRent\Core\Contract\Query
 * @author Simon Bennett <simon@bennett.im>
 */
interface ContractReadRepository
{
    /**
     * @param PropertyId $propertyId
     * @return \stdClass
     */
    public function getByProperty(PropertyId $propertyId);

    /**
     * @param ContractId $contractId
     * @return \stdClass
     */
    public function getById(ContractId $contractId);

    /**
     * @param TenantId $tenantId
     * @return \stdClass
     */
    public function getByTenantId(TenantId $tenantId);

    /**
     * @param $companyId
     * @return mixed
     */
    public function getByCompany($companyId);
}