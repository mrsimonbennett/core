<?php
namespace FullRent\Core\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\User\Events\UserFinishedApplication;
use FullRent\Core\User\Events\UserHasChangedName;
use FullRent\Core\User\Events\UserHasRequestedPasswordReset;
use FullRent\Core\User\Events\UserInvited;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use FullRent\Core\User\Exceptions\InvalidPasswordResetRequest;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\InviteToken;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\PasswordResetToken;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class User
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class User extends EventSourcedAggregateRoot
{
    /** @var UserId */
    private $userId;

    /** @var Email */
    private $email;

    /**  @var PasswordResetToken */
    private $resetToken;

    /**  @var InviteToken */
    private $inviteToken;


    /**
     * @param UserId   $userId
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     * @param Timezone $timezone
     * @return User
     */
    public static function registerUser(UserId $userId, Name $name, Email $email, Password $password, Timezone $timezone)
    {
        $user = new static();
        $user->apply(new UserRegistered($userId, $name, $email, $password, DateTime::now(), $timezone));

        return $user;
    }

    /**
     * Invite user to fullrent, This process we sent them a email and they have to fill out some basic information first
     *
     * We are missing there password and name
     *
     * @param UserId $userId
     * @param Email $email
     * @return User
     */
    public static function inviteUser(UserId $userId, Email $email)
    {
        $user = new static();
        $user->apply(new UserInvited($userId, $email, InviteToken::random((string)$email), DateTime::now()));

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
     * Request a password reset
     */
    public function requestPasswordReset()
    {
        //Build token
        $token = PasswordResetToken::random($this->email);
        $this->apply(new UserHasRequestedPasswordReset($this->userId,
                                                       $this->email,
                                                       $token,
                                                       DateTime::now()->addHours(4),
                                                       DateTime::now()));
    }

    /**
     * Change the user password using the user provided token
     *
     * @param Password $password
     * @param PasswordResetToken $passwordResetToken
     * @throws InvalidPasswordResetRequest If the token is not correct/outdated
     */
    public function resetUserPassword(Password $password, PasswordResetToken $passwordResetToken)
    {
        if (isset($this->resetToken) && $this->resetToken->equals($passwordResetToken)) {
            $this->apply(new UserPasswordReset($this->userId, $password, DateTime::now()));

            return;
        }

        throw new InvalidPasswordResetRequest();
    }

    public function finishApplication(InviteToken $inviteToken, Password $password, Name $name)
    {
        if (isset($this->inviteToken) && $this->inviteToken->equals($inviteToken)) {
            $this->apply(new UserFinishedApplication($this->userId, $password, $name, DateTime::now()));

            return;
        }
        throw new InvalidInviteToken;
    }

    /**
     * @param UserRegistered $userRegistered
     */
    protected function applyUserRegistered(UserRegistered $userRegistered)
    {
        $this->userId = $userRegistered->getUserId();
        $this->email = $userRegistered->getEmail();
        $this->timezone = $userRegistered->getTimezone();
    }

    /**
     * @param UserInvited $e
     */
    protected function applyUserInvited(UserInvited $e)
    {
        $this->userId = $e->getUserId();
        $this->email = $e->getEmail();
        $this->inviteToken = $e->getInviteToken();
    }

    /**
     * @param UsersEmailHasChanged $usersEmailHasChanged
     */
    protected function applyUsersEmailHasChanged(UsersEmailHasChanged $usersEmailHasChanged)
    {
        $this->email = $usersEmailHasChanged->getEmail();
    }

    /**
     * If the code is still valid we will set it in a field if not set the field back to null
     * @param UserHasRequestedPasswordReset $e
     */
    protected function applyUserHasRequestedPasswordReset(UserHasRequestedPasswordReset $e)
    {
        $this->resetToken = null;
        if ($e->getValidTill()->isFuture()) {
            $this->resetToken = $e->getPasswordResetToken();
        }
    }

    /**
     * When the user finishes there application we will set there invite token back to null
     * @param UserFinishedApplication $e
     */
    protected function applyUserFinishedApplication(UserFinishedApplication $e)
    {
        $this->inviteToken = null;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'user-' . (string)$this->userId;
    }

}