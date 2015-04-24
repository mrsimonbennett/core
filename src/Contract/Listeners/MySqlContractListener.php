<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;

/**
 * Class MySqlContractListener
 * @package FullRent\Core\Contract\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class MySqlContractListener extends BaseMysqlSubscriber
{
    /**
     * @param ContractDraftedFromApplication $e
     * @hears("FullRent.Core.Contract.Events.ContractDraftedFromApplication")
     */
    public function whenContractIsDrafted(ContractDraftedFromApplication $e)
    {
        $this->db
            ->table('contracts')
            ->insert(
                [
                    'id'             => $e->getContractId(),
                    'company_id'     => $e->getCompanyId(),
                    'application_id' => $e->getApplicationId(),
                    'property_id'    => $e->getPropertyId(),
                    'landlord_id'    => $e->getLandlordId(),
                    'created_at'     => $e->getDraftedAt(),
                ]
            );
    }

    /**
     * @param TenantJoinedContract $e
     * @hears("FullRent.Core.Contract.Events.TenantJoinedContract")
     */
    public function whenTenantJoinsContractInsertMysql(TenantJoinedContract $e)
    {
        $this->db
            ->table('contract_tenants')
            ->insert(
                [
                    'tenant_id' => $e->getTenantId(),
                    'contract_id' => $e->getContractId(),
                ]
            );
    }
}