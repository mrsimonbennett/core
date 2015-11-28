<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\CompanyId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\ValueObjects\TenantEmail;
use FullRent\Core\Tenancy\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class InvitedNewUserToTenancy
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class InvitedNewUserToTenancy implements Event, Serializable
{
    /** @var TenancyId */
    private $id;

    /** @var TenantId */
    private $tenantId;

    /** @var TenantEmail */
    private $tenantEmail;

    /** @var DateTime */
    private $invitedAt;

    /** @var CompanyId */
    private $companyId;

    /**
     * InvitedNewUserToTenancy constructor.
     * @param TenancyId $id
     * @param TenantId $tenantId
     * @param TenantEmail $tenantEmail
     * @param CompanyId $companyId
     * @param DateTime $invitedAt
     */
    public function __construct(
        TenancyId $id,
        TenantId $tenantId,
        TenantEmail $tenantEmail,
        CompanyId $companyId,
        DateTime $invitedAt
    ) {
        $this->id = $id;
        $this->tenantId = $tenantId;
        $this->tenantEmail = $tenantEmail;
        $this->invitedAt = $invitedAt;
        $this->companyId = $companyId;
    }

    /**
     * @return TenancyId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return TenantEmail
     */
    public function getTenantEmail()
    {
        return $this->tenantEmail;
    }

    /**
     * @return DateTime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tenancy_id'   => (string)$this->id,
            'tenant_id'    => (string)$this->tenantId,
            'tenant_email' => $this->tenantEmail->serialize(),
            'company_id'   => (string)$this->companyId,
            'invited_at'   => $this->invitedAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new TenancyId($data['tenancy_id']),
                          new TenantId($data['tenant_id']),
                          TenantEmail::deserialize($data['tenant_email']),
                          new CompanyId($data['company_id']),
                          DateTime::deserialize($data['invited_at']));
    }
}