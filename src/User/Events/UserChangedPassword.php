<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UserChangedPassword
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserChangedPassword implements Event, Serializable
{
    /** @var UserId */
    private $userId;

    /** @var Password */
    private $newPassword;

    /** @var DateTime */
    private $changedAt;

    /**
     * UserChangedPassword constructor.
     * @param UserId $userId
     * @param Password $newPassword
     * @param DateTime $changedAt
     */
    public function __construct(UserId $userId, Password $newPassword, DateTime $changedAt)
    {
        $this->userId = $userId;
        $this->newPassword = $newPassword;
        $this->changedAt = $changedAt;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Password
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @return DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'    => (string)$this->userId,
            'password'   => $this->newPassword->serialize(),
            'changed_at' => $this->changedAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Password::deserialize($data['password']),
                          DateTime::deserialize($data['changed_at']));
    }
}