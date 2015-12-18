<?php
namespace FullRent\Core\Tenancy;

use FullRent\Core\Tenancy\Events\InvitedExistingUserToTenancy;
use FullRent\Core\Tenancy\Events\InvitedNewUserToTenancy;
use FullRent\Core\Tenancy\Events\RemovedScheduledRentPayment;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\Events\TenancyRentPaymentScheduled;
use FullRent\Core\Tenancy\Events\TenancyRentScheduledPaymentAmended;
use FullRent\Core\Tenancy\Events\TenancySetToFullRentCollection;
use FullRent\Core\Tenancy\Exceptions\RentPaymentNotFound;
use FullRent\Core\Tenancy\ValueObjects\CompanyId;
use FullRent\Core\Tenancy\ValueObjects\DocumentId;
use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\ValueObjects\TenantEmail;
use FullRent\Core\Tenancy\ValueObjects\TenantId;
use FullRent\Core\Tenancy\ValueObjects\TenantInviteCode;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Tenancy
 * @package FullRent\Core\Tenancy
 * @author Simon Bennett <simon@bennett.im>
 */
final class Tenancy extends AggregateRoot
{
    /**
     * @var TenancyId
     */
    private $tenancyId;

    /** @var */
    private $scheduledPayments;

    /**
     * @var CompanyId
     */
    private $companyId;

    /** @var DocumentId[] */
    private $documents = [];

    /**
     * @param TenancyId $tenancyId
     * @param PropertyId $propertyId
     * @param CompanyId $companyId
     * @param TenancyDuration $tenancyDuration
     * @param RentDetails $rentDetails
     * @return static
     */
    public static function draft(
        TenancyId $tenancyId,
        PropertyId $propertyId,
        CompanyId $companyId,
        TenancyDuration $tenancyDuration,
        RentDetails $rentDetails
    ) {
        $tenancy = new static();
        $tenancy->apply(new TenancyDrafted($tenancyId,
                                           $propertyId,
                                           $companyId,
                                           $tenancyDuration,
                                           $rentDetails,
                                           new DateTime()));

        return $tenancy;
    }


    /**
     * @param RentPaymentId $rentPaymentId
     * @param RentAmount $rentAmount
     * @param DateTime $due
     */
    public function schedulePayment(RentPaymentId $rentPaymentId, RentAmount $rentAmount, DateTime $due)
    {
        $this->apply(new TenancyRentPaymentScheduled($this->tenancyId,
                                                     $rentPaymentId,
                                                     $rentAmount,
                                                     $due,
                                                     new DateTime()));
    }

    /**
     * @param RentPaymentId $rentPaymentId
     * @param RentAmount $rentAmount
     * @param DateTime $due
     */
    public function amendScheduledPayment(RentPaymentId $rentPaymentId, RentAmount $rentAmount, DateTime $due)
    {
        if (!isset($this->scheduledPayments[(string)$rentPaymentId])) {
            throw new RentPaymentNotFound;
        }

        $this->apply(new TenancyRentScheduledPaymentAmended($this->tenancyId,
                                                            $rentPaymentId,
                                                            $rentAmount,
                                                            $due,
                                                            new DateTime()));
    }

    /**
     * @param RentPaymentId $rentPaymentId
     */
    public function removeScheduledRent(RentPaymentId $rentPaymentId)
    {
        if (!isset($this->scheduledPayments[(string)$rentPaymentId])) {
            throw new RentPaymentNotFound;
        }

        $this->apply(new RemovedScheduledRentPayment($this->tenancyId, $rentPaymentId, new DateTime()));
    }

    /**
     * @param TenantId $tenantId
     * @param TenantEmail $tenantEmail
     */
    public function inviteNewUser(TenantId $tenantId, TenantEmail $tenantEmail)
    {
        $this->apply(new InvitedNewUserToTenancy($this->tenancyId,
                                                 $tenantId,
                                                 $tenantEmail,
                                                 $this->companyId,
                                                 TenantInviteCode::random((string)$tenantEmail),
                                                 new DateTime()));
    }

    /**
     * @param TenantId $tenantId
     */
    public function inviteExistingUser(TenantId $tenantId)
    {
        $this->apply(new InvitedExistingUserToTenancy($this->tenancyId, $tenantId, $this->companyId, new DateTime()));
    }

    public function setCollectDirectDebitWithFullRent()
    {
        $this->apply(new TenancySetToFullRentCollection($this->tenancyId,new DateTime()));
    }

    /**
     * @param TenancyDrafted $e
     */
    protected function applyTenancyDrafted(TenancyDrafted $e)
    {
        $this->tenancyId = $e->getTenancyId();
        $this->companyId = $e->getCompanyId();

    }

    /**
     * @param DocumentId $newDocumentId
     */
    public function attachDocument(DocumentId $newDocumentId)
    {
        foreach ($this->documents as $documentId) {
            if ($documentId->equal($newDocumentId)) {
                throw new Exceptions\DocumentAlreadyAdded('This document has already been added to the tenancy');
            }
        }

        $this->apply(new Events\DocumentAttachedToTenancy($this->tenancyId, $newDocumentId, DateTime::now()));
    }

    /**
     * @param TenancyRentPaymentScheduled $e
     */
    protected function applyTenancyRentPaymentScheduled(TenancyRentPaymentScheduled $e)
    {
        $this->scheduledPayments[(string)$e->getRentPaymentId()] = [
            'rent_amount' => $e->getRentAmount(),
            'rent_due'    => $e->getDue()
        ];
    }

    /**
     * @param RemovedScheduledRentPayment $e
     */
    protected function applyRemovedScheduledRentPayment(RemovedScheduledRentPayment $e)
    {
        unset($this->scheduledPayments[(string)$e->getRentPaymentId()]);
    }

    /**
     * @param Events\DocumentAttachedToTenancy $e
     */
    protected function applyDocumentAttachedToTenancy(Events\DocumentAttachedToTenancy $e)
    {
        $this->documents[] = $e->getDocumentId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'tenancy-' . $this->tenancyId;
    }


}