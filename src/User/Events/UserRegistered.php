<?php
namespace FullRent\Core\User\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\ValueObjects\Timezone;

/**
 * Class UserRegistered
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserRegistered implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
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
     * @var DateTime
     */
    private $createdAt;
    /** @var Timezone */
    private $timezone;

    /**
     * @param UserId   $userId
     * @param Name     $name
     * @param Email    $email
     * @param Password $password
     * @param DateTime $createdAt
     * @param Timezone $timezone
     */
    public function __construct(UserId $userId, Name $name, Email $email, Password $password, DateTime $createdAt, Timezone $timezone)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->timezone = $timezone;
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

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new UserId($data['id']),
            Name::deserialize($data['name']),
            Email::deserialize($data['email']),
            Password::deserialize($data['password']),
            DateTime::deserialize($data['created']),
            Timezone::deserialize($data['timezone'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return
            [
                'id' => (string)$this->userId,
                'name' => $this->name->serialize(),
                'email' => $this->email->serialize(),
                'password' => $this->password->serialize(),
                'created' => $this->createdAt->serialize(),
                'timezone' => $this->timezone->serialize(),
            ];
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}