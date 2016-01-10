<?php
namespace FullRent\Core\Projections\Tenanies\Queries;

/**
 * Class FindAllTenantsTenancies
 * @package FullRent\Core\Projections\Tenanies\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAllTenantsTenancies
{
    private $tenantId;

    /**
     * FindAllTenantsTenancies constructor.
     * @param $tenantId
     */
    public function __construct($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    /**
     * @return mixed
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

}