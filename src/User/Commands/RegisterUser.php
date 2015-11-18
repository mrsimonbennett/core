<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\Timezone;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RegisterUser
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterUser extends BaseCommand
{
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var Name
     */
    private $name;
    /**
     * @var Email
     */
    private $email;
    /**
     * @var Password
     */
    private $password;
    /**
     * @var Timezone
     */
    private $timezone;

    /**
     * @param UserId   $userId
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     * @param Timezone $timezone
     */
    public function __construct(UserId $userId, Name $name, Email $email, Password $password, Timezone $timezone)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->timezone = $timezone;
        parent::__construct();
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return Timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}