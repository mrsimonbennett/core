<?php
namespace FullRent\Core\User\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\User\ValueObjects\InviteToken;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\ValueObjects\Person\Email;

/**
 * Class UserInvited
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserInvited implements SerializableInterface
{
    /** @var UserId */
    private $userId;

    /** @var Email */
    private $email;

    /** @var DateTime */
    private $invitedAt;

    /** @var InviteToken */
    private $inviteToken;

    /**
     * @param UserId $userId
     * @param Email $email
     * @param InviteToken $inviteToken
     * @param DateTime $invitedAt
     */
    public function __construct(UserId $userId, Email $email, InviteToken $inviteToken, DateTime $invitedAt)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->invitedAt = $invitedAt;
        $this->inviteToken = $inviteToken;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return InviteToken
     */
    public function getInviteToken()
    {
        return $this->inviteToken;
    }

    /**
     * @return DateTime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Email::deserialize($data['email']),
                          InviteToken::deserialize($data['invite_token']),
                          DateTime::deserialize($data['invited_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'      => (string)$this->userId,
            'email'        => $this->email->serialize(),
            'invite_token' => $this->inviteToken->serialize(),
            'invited_at'   => $this->invitedAt->serialize()
        ];
    }
}