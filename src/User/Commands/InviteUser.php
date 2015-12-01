<?php
namespace FullRent\Core\User\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class InviteUser
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteUser extends BaseCommand
{
    /** @var string */
    private $userId;

    /** @var string */
    private $email;

    /** @var */
    private $code;

    /**
     * @param string $userId
     * @param string $email
     * @param $code
     */
    public function __construct($userId, $email, $code)
    {
        $this->userId = $userId;
        $this->email = $email;

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

}