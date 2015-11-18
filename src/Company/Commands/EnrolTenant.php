<?php
namespace FullRent\Core\Company\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class EnrolTenant
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EnrolTenant extends BaseCommand
{
    /**
     * @var string
     */
    private $companyId;
    /**
     * @var string
     */
    private $tenantId;

    /**
     * @param string $companyId
     * @param string $tenantId
     */
    public function __construct($companyId, $tenantId)
    {
        $this->companyId = $companyId;
        $this->tenantId = $tenantId;


    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

}