<?php
namespace FullRent\Core\User\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class UserFinishedApplication
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserFinishedApplication implements SerializableInterface
{
    /** @var UserId */
    private $userId;

    /** @var Password */
    private $password;

    /** @var Name */
    private $name;

    /** @var DateTime */
    private $finishedAt;

    /**
     * UserFinishedApplication constructor.
     * @param UserId $userId
     * @param Password $password
     * @param Name $name
     * @param DateTime $finishedAt
     */
    public function __construct(UserId $userId, Password $password, Name $name, DateTime $finishedAt)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->name = $name;
        $this->finishedAt = $finishedAt;
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
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Password::deserialize($data['password']),
                          Name::deserialize($data['name']),
                          DateTime::deserialize($data['finished_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'     => (string)$this->userId,
            'password'    => $this->password->serialize(),
            'name'        => $this->name->serialize(),
            'finished_at' => $this->finishedAt->serialize(),
        ];
    }
}