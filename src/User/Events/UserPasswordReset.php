<?php
namespace FullRent\Core\User\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class UserPasswordReset
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserPasswordReset implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var UserId */
    private $userId;

    /** @var Password */
    private $password;

    /** @var DateTime */
    private $updatedAt;

    /**
     * @param UserId $userId
     * @param Password $password
     * @param DateTime $updatedAt
     */
    public function __construct(UserId $userId, Password $password, DateTime $updatedAt)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->updatedAt = $updatedAt;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Password::deserialize($data['password']),
                          DateTime::deserialize($data['updated_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'    => (string)$this->userId,
            'password'   => $this->password->serialize(),
            'updated_at' => $this->updatedAt->serialize(),
        ];
    }
}