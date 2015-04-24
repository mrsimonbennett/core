<?php
namespace FullRent\Core\Contract\Query;

use FullRent\Core\Contract\ValueObjects\PropertyId;
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
        $contracts =  $this->db->table('contracts')->where('property_id', $propertyId)->get();
        foreach($contracts as $contract)
        {
            $contract->tenants = $this->db->table('contract_tenants')->where('contract_id',$contract->id)->join('users','users.id','=','contract_tenants.tenant_id')->get();
        }
        return $contracts;
    }
}