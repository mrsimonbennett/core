<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
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
     * @param UserId   $userId
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     */
    public function __construct(UserId $userId, Name $name, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

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
}