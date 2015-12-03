<?php
namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class InviteExistingUserToTenancy
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteExistingUserToTenancy extends BaseCommand
{
    /** @var */
    private $tenancyId;

    /** @var */
    private $tenantId;

    /**
     * InviteExistingUserToTenancy constructor.
     * @param $tenancyId
     * @param $tenantId
     */
    public function __construct($tenancyId, $tenantId)
    {
        $this->tenancyId = $tenancyId;
        $this->tenantId = $tenantId;
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

}