<?php
namespace FullRent\Core\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class User
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class User extends EventSourcedAggregateRoot
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
     * @param UserId $userId
     * @param Name $name
     * @param Email $email
     * @param Password $password
     * @return static
     */
    public static function registerUser(UserId $userId, Name $name, Email $email, Password $password)
    {
        $user = new static();
        $user->apply(new UserRegistered($userId, $name, $email, $password));

        return $user;
    }

    /**
     * @param UserRegistered $userRegistered
     */
    public function applyUserRegistered(UserRegistered $userRegistered)
    {
        $this->userId = $userRegistered->getUserId();
        $this->name = $userRegistered->getName();
        $this->email = $userRegistered->getEmail();
        $this->password = $userRegistered->getPassword();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->userId;
    }
}