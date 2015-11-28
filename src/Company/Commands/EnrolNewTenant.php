<?php
namespace FullRent\Core\Company\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class EnrolNewTenant
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EnrolNewTenant extends BaseCommand
{
    private $companyId;

    private $tenancyId;

    private $tenantId;

    private $tenantEmail;

    /**
     * EnrolNewTenant constructor.
     * @param $companyId
     * @param $tenancyId
     * @param $tenantId
     * @param $tenantEmail
     */
    public function __construct($companyId, $tenancyId, $tenantId, $tenantEmail)
    {
        $this->companyId = $companyId;
        $this->tenancyId = $tenancyId;
        $this->tenantId = $tenantId;
        $this->tenantEmail = $tenantEmail;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return mixed
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return mixed
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return mixed
     */
    public function getTenantEmail()
    {
        return $this->tenantEmail;
    }

}