<?php
namespace FullRent\Core\User\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\PasswordResetToken;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class UserHasRequestedPasswordReset
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserHasRequestedPasswordReset implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var UserId */
    private $userId;

    /** @var Email */
    private $email;

    /** @var PasswordResetToken */
    private $passwordResetToken;

    /** @var DateTime */
    private $validTill;

    /** @var DateTime */
    private $requestedAt;

    /**
     * @param UserId $userId
     * @param Email $email
     * @param PasswordResetToken $passwordResetToken
     * @param DateTime $validTill
     * @param DateTime $requestedAt
     */
    public function __construct(
        UserId $userId,
        Email $email,
        PasswordResetToken $passwordResetToken,
        DateTime $validTill,
        DateTime $requestedAt
    ) {
        $this->userId = $userId;
        $this->email = $email;
        $this->passwordResetToken = $passwordResetToken;
        $this->validTill = $validTill;
        $this->requestedAt = $requestedAt;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return PasswordResetToken
     */
    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * @return DateTime
     */
    public function getValidTill()
    {
        return $this->validTill;
    }

    /**
     * @return DateTime
     */
    public function getRequestedAt()
    {
        return $this->requestedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Email::deserialize($data['email']),
                          PasswordResetToken::deserialize($data['password_reset_token']),
                          DateTime::deserialize($data['valid_till']),
                          DateTime::deserialize($data['requested_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'              => (string)$this->userId,
            'email'                => $this->email->serialize(),
            'password_reset_token' => $this->passwordResetToken->serialize(),
            'valid_till'           => $this->validTill->serialize(),
            'requested_at'         => $this->requestedAt->serialize()
        ];
    }
}