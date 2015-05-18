<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Events\ContractRentInformationDrafted;
use FullRent\Core\Contract\Events\ContractRentPeriodSet;
use FullRent\Core\Contract\Events\ContractSetRequiredDocuments;
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
                    'tenant_id'   => $e->getTenantId(),
                    'contract_id' => $e->getContractId(),
                ]
            );
    }

    /**
     * @param ContractRentPeriodSet $e
     * @hears("FullRent.Core.Contract.Events.ContractRentPeriodSet")
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
     * @hears("FullRent.Core.Contract.Events.ContractRentInformationDrafted")
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
     * @hears("FullRent.Core.Contract.Events.ContractSetRequiredDocuments")
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
     * @hears("FullRent.Core.Contract.Events.ContractLocked")
     */
    public function whenContractIsLockedUpdateMysql(ContractLocked $e)
    {
        $this->db->table('contracts')
                 ->where('id', $e->getContractId())
                 ->update(
                     [
                         'locked' => true,
                         'status' => "Pending on Tenant(s)",
                         'waiting_on_landlord' => false,
                     ]
                 );
    }
}