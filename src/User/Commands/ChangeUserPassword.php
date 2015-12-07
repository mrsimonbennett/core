<?php
namespace FullRent\Core\User\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ChangeUserPassword
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeUserPassword extends BaseCommand
{
    /** @var */
    private $userId;

    /** @var */
    private $oldPassword;

    /** @var */
    private $newPassword;

    /**
     * ChangeUserPassword constructor.
     * @param $userId
     * @param $oldPassword
     * @param $newPassword
     */
    public function __construct($userId, $oldPassword, $newPassword)
    {
        $this->userId = $userId;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
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
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

}