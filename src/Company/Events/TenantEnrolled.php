<?php
namespace FullRent\Core\Company\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class TenantEnrolled
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantEnrolled implements SerializableInterface
{
    /**
     * @var CompanyId
     */
    private $companyId;
    /**
     * @var TenantId
     */
    private $tenantId;
    /**
     * @var DateTime
     */
    private $enrolledAt;

    /**
     * @param CompanyId $companyId
     * @param TenantId $tenantId
     * @param DateTime $enrolledAt
     */
    public function __construct(CompanyId $companyId, TenantId $tenantId, DateTime $enrolledAt)
    {
        $this->companyId = $companyId;
        $this->tenantId = $tenantId;
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
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new CompanyId($data['company_id']),
            new TenantId($data['tenant_id']),
            DateTime::deserialize($data['enrolled'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'company_id' => (string)$this->companyId,
            'tenant_id'  => (string)$this->tenantId,
            'enrolled'   => $this->enrolledAt->serialize()
        ];
    }
}