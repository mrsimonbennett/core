<?php
namespace FullRent\Core\User;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\User\Events\UserHasChangedName;
use FullRent\Core\User\Events\UserHasRequestedPasswordReset;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use FullRent\Core\User\Exceptions\InvalidPasswordResetRequest;
use FullRent\Core\User\ValueObjects\Email;
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
        $user->apply(new UserRegistered($userId, $name, $email, $password, DateTime::now()));

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


    /**
     * @param UserRegistered $userRegistered
     */
    protected function applyUserRegistered(UserRegistered $userRegistered)
    {
        $this->userId = $userRegistered->getUserId();
        $this->email = $userRegistered->getEmail();
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
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'user-' . (string)$this->userId;
    }

}