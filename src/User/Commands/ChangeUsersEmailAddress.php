<?php
namespace FullRent\Core\User\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ChangeUsersEmailAddress
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeUsersEmailAddress extends BaseCommand
{
    /** @var string */
    private $userId;

    /** @var string */
    private $email;

    /**
     * ChangeUsersEmailAddress constructor.
     * @param string $userId
     * @param string $email
     */
    public function __construct($userId, $email)
    {
        $this->userId = $userId;
        $this->email = $email;
        parent::__construct();
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

}