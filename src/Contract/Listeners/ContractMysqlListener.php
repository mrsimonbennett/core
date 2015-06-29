<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Events\ContractRentInformationDrafted;
use FullRent\Core\Contract\Events\ContractRentPeriodSet;
use FullRent\Core\Contract\Events\ContractSetRequiredDocuments;
use FullRent\Core\Contract\Events\LandlordSignedContract;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Events\TenantSignedContract;
use FullRent\Core\Contract\Events\TenantUploadedEarningsDocument;
use FullRent\Core\Contract\Events\TenantUploadedIdDocument;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class MySqlContractListener
 * @package FullRent\Core\Contract\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractMysqlListener extends EventListener
{
    public function __construct(MySqlClient $client)
    {
        $this->db = $client->query();
    }

    /**
     * @param ContractDraftedFromApplication $e
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
     * @param ContractRentPeriodSet $e
     */
    public function whenContractPeriodIsSet(ContractRentPeriodSet $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'start'           => $e->getStart(),
                         'end'             => $e->getEnd(),
                         'completed_dates' => true
                     ]
                 );
    }

    /**
     * @param ContractRentInformationDrafted $e
     */
    public function whenContractRentIsDrafted(ContractRentInformationDrafted $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'rent'                     => $e->getRent()->getRentAmount()->getAmountInPounds(),
                         'deposit'                  => $e->getDeposit()->getDepositAmount()->getAmountInPounds(),
                         'rent_payable'             => $e->getRent()->getRentDueDay(),
                         'fullrent_rent_collection' => $e->getRent()->isFullRentRentCollection(),
                         'first_rent'               => $e->getRent()->getFirstPayment(),
                         'deposit_due'              => $e->getDeposit()->getDepositDue(),
                         'fullrent_deposit'         => $e->getDeposit()->isFullRentProvided(),
                         'completed_rent'           => true
                     ]
                 );
    }

    /**
     * @param ContractSetRequiredDocuments $e
     */
    public function whenContractDocumentsUpdated(ContractSetRequiredDocuments $e)
    {
        $requireId = false;
        $requireProofOfEarning = false;

        foreach ($e->getDocuments() as $document) {
            if ($document->getName() == 'require_id') {
                $requireId = true;
            } else {
                if ($document->getName() == 'require_earnings_proof') {
                    $requireProofOfEarning = true;
                }
            }
        }
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'require_id'             => $requireId,
                         'require_earnings_proof' => $requireProofOfEarning,
                         'completed_documents'    => true
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
     * @param TenantUploadedIdDocument $e
     */
    public function whenContractIdDocumentProvided(TenantUploadedIdDocument $e)
    {
        $this->db->table('contract_documents')
                 ->insert([
                              'id'          => $e->getDocumentId(),
                              'tenant_id'   => $e->getTenantId(),
                              'contract_id' => $e->getContractId(),
                              'uploaded_at' => $e->getUploadedAt(),
                              'type'        => 'id',
                          ]);
    }

    /**
     * @param TenantUploadedEarningsDocument $e
     */
    public function whenContractProofOfEarningsProvided(TenantUploadedEarningsDocument $e)
    {
        $this->db->table('contract_documents')
                 ->insert([
                              'id'          => $e->getDocumentId(),
                              'tenant_id'   => $e->getTenantId(),
                              'contract_id' => $e->getContractId(),
                              'uploaded_at' => $e->getUploadedAt(),
                              'type'        => 'earnings',
                          ]);
    }

    /**
     * @param TenantSignedContract $e
     */
    public function whenTenantSignsContract(TenantSignedContract $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'status'              => "Pending on Landlord",
                         'waiting_on_landlord' => true,
                         'waiting_on_tenant'   => false,
                         'tenant_signed'       => true,
                         'tenant_signature'    => $e->getSignature(),
                     ]
                 );
    }

    /**
     * @param LandlordSignedContract $e
     */
    public function whenLandlordSignsContract(LandlordSignedContract $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'status'              => "Activated",
                         'waiting_on_landlord' => false,
                         'waiting_on_tenant'   => false,
                         'active'              => true,
                         'landlord_signed'     => true,
                         'landlord_signature'  => $e->getSignature(),
                     ]
                 );
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenContractIsDrafted'               => ContractDraftedFromApplication::class,
            'whenTenantJoinsContractInsertMysql'  => TenantJoinedContract::class,
            'whenContractPeriodIsSet'             => ContractRentPeriodSet::class,
            'whenContractRentIsDrafted'           => ContractRentInformationDrafted::class,
            'whenContractDocumentsUpdated'        => ContractSetRequiredDocuments::class,
            'whenContractIsLockedUpdateMysql'     => ContractLocked::class,
            'whenContractIdDocumentProvided'      => TenantUploadedIdDocument::class,
            'whenContractProofOfEarningsProvided' => TenantUploadedEarningsDocument::class,
            'whenTenantSignsContract'             => TenantSignedContract::class,
            'whenLandlordSignsContract'           => LandlordSignedContract::class,
        ];
    }
}