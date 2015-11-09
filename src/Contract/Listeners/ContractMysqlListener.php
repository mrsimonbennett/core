<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Contract\Events\ContractDrafted;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Events\ContractRentInformationDrafted;
use FullRent\Core\Contract\Events\ContractRentPeriodSet;
use FullRent\Core\Contract\Events\ContractSetRequiredDocuments;
use FullRent\Core\Contract\Events\LandlordSignedContract;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Events\TenantSignedContract;
use FullRent\Core\Contract\Events\TenantUploadedEarningsDocument;
use FullRent\Core\Contract\Events\TenantUploadedIdDocument;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class MySqlContractListener
 * @package FullRent\Core\Contract\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractMysqlListener implements Subscriber, Projection
{
    protected $priority = 100;

    public function __construct(MySqlClient $client)
    {
        $this->db = $client->query();
    }


    /**
     * @param ContractDrafted $e
     */
    public function whenContractIsDrafted(ContractDrafted $e)
    {
        $this->db
            ->table('contracts')
            ->insert(
                [
                    'id'                       => $e->getContractId(),
                    'company_id'               => $e->getCompanyId(),
                    'property_id'              => $e->getPropertyId(),
                    'landlord_id'              => $e->getLandlordId(),
                    'start'                    => $e->getRentDetails()->getStart(),
                    'end'                      => $e->getRentDetails()->getEnd(),
                    'rent'                     => $e->getRentDetails()->getRentAmount()->getAmountInPounds(),
                    'rent_payable'             => $e->getRentDetails()->getRentDueDay()->getRentDueDay(),
                    'fullrent_rent_collection' => $e->getRentDetails()->isFullRentRentCollection(),
                    'first_rent'               => $e->getRentDetails()->getFirstPayment(),
                    'created_at'               => $e->getDraftedAt(),
                ]
            );
    }


    /**
     * @param ContractLocked $e
     */
    public function whenContractIsLockedUpdateMysql(ContractLocked $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'locked'              => true,
                         'status'              => "Pending on Tenant(s)",
                         'waiting_on_landlord' => false,
                         'waiting_on_tenant'   => true,

                     ]
                 );
    }

    /**
     * @param TenantJoinedContract $e
     */
    public function whenTenantJoinsContractInsertMysql(TenantJoinedContract $e)
    {
        $this->db
            ->table('contract_tenants')
            ->insert(
                [
                    'tenant_id'   => $e->getTenantId(),
                    'contract_id' => $e->getContractId(),
                ]
            );
    }
    
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            ContractDrafted::class      => ['whenContractIsDrafted'],
            TenantJoinedContract::class => ['whenTenantJoinsContractInsertMysql'],
        ];
    }
}