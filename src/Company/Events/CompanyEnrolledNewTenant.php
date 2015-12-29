<?php
namespace FullRent\Core\Company\Events;

use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\TenancyId;
use FullRent\Core\Company\ValueObjects\TenantId;
use FullRent\Core\Company\ValueObjects\TenantEmail;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class CompanyEnrolledNewTenant
 * @package FullRent\Core\CompanyModal\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyEnrolledNewTenant implements Serializable, Event
{
    /** @var CompanyId */
    private $companyId;

    /** @var TenantId */
    private $tenantId;

    /** @var TenancyId */
    private $tenancyId;

    /** @var TenantEmail */
    private $tenantEmail;

    /** @var DateTime */
    private $enrolledAt;

    /**
     * CompanyEnrolledNewTenant constructor.
     * @param CompanyId $companyId
     * @param TenantId $tenantId
     * @param TenancyId $tenancyId
     * @param TenantEmail $tenantEmail
     * @param DateTime $enrolledAt
     */
    public function __construct(
        CompanyId $companyId,
        TenantId $tenantId,
        TenancyId $tenancyId,
        TenantEmail $tenantEmail,
        DateTime $enrolledAt
    ) {
        $this->companyId = $companyId;
        $this->tenantId = $tenantId;
        $this->tenancyId = $tenancyId;
        $this->tenantEmail = $tenantEmail;
        $this->enrolledAt = $enrolledAt;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
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
    public function getEnrolledAt()
    {
        return $this->enrolledAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {

        return [
            'company_id'   => (string)$this->companyId,
            'tenant_id'    => (string)$this->tenantId,
            'tenancy_id'   => (string)$this->tenancyId,
            'tenant_email' => $this->tenantEmail->serialize(),
            'enrolled_at'  => $this->enrolledAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['company_id']),
                          new TenantId($data['tenant_id']),
                          new TenancyId($data['tenancy_id']),
                          TenantEmail::deserialize($data['tenant_email']),
                          DateTime::deserialize($data['enrolled_at']));
    }
}