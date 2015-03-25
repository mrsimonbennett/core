<?php
namespace FullRent\Core\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\User\Events\UserHasChangedName;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
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
     * @return User
     */
    public static function registerUser(UserId $userId, Name $name, Email $email, Password $password)
    {
        $user = new static();
        $user->apply(new UserRegistered($userId, $name, $email, $password));

        return $user;
    }

    /**
     * @param Email $email
     */
    public function changeEmail(Email $email)
    {
        $this->apply(new UsersEmailHasChanged($email));
    }

    /**
     * @param Name $name
     */
    public function changeName(Name $name)
    {
        $this->apply(new UserHasChangedName($name));
    }

    /**
     * @param UserRegistered $userRegistered
     */
    protected function applyUserRegistered(UserRegistered $userRegistered)
    {
        $this->userId = $userRegistered->getUserId();
        $this->name = $userRegistered->getName();
        $this->email = $userRegistered->getEmail();
        $this->password = $userRegistered->getPassword();
    }

    /**
     * @param UsersEmailHasChanged $usersEmailHasChanged
     */
    protected function applyUsersEmailHasChanged(UsersEmailHasChanged $usersEmailHasChanged)
    {
        $this->email = $usersEmailHasChanged->getEmail();
    }

    /**
     * @param UserHasChangedName $userHasChangedName
     */
    protected function applyUserHasChangedName(UserHasChangedName $userHasChangedName)
    {
        $this->name = $userHasChangedName->getName();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'user-'.(string)$this->userId;
    }
}