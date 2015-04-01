<?php
namespace FullRent\Core\User\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class UserRegistered
 * @package FullRent\Core\User
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserRegistered implements SerializableInterface
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
     */
    public function __construct(UserId $userId, Name $name, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
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
            Password::deserialize($data['password'])
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
            ];
    }
}