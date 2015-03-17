<?php
namespace FullRent\Core\Contract\ValueObjects;

/**
 * Class Tenant
 * @package FullRent\Core\Contract\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class Tenant
{
    /**
     * @var TenantId
     */
    private $tenantId;

    /**
     * @param TenantId $tenantId
     */
    public function __construct(TenantId $tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

}