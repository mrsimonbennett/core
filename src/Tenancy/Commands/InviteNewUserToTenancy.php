<?php
namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class InviteNewUserToTenancy
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteNewUserToTenancy extends BaseCommand
{
    private $tenancyId;

    private $userId;

    private $userEmail;

    /**
     * InviteNewUserToTenancy constructor.
     * @param $tenancyId
     * @param $userId
     * @param $userEmail
     */
    public function __construct($tenancyId, $userId, $userEmail)
    {
        $this->tenancyId = $tenancyId;
        $this->userId = $userId;
        $this->userEmail = $userEmail;
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

}