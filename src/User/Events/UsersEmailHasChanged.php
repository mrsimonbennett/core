<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UsersEmailHasChanged
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UsersEmailHasChanged implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var Email
     */
    private $email;

    /** @var UserId */
    private $id;

    /** @var DateTime */
    private $changedAt;

    /**
     * @param UserId $id
     * @param Email $email
     * @param DateTime $changedAt
     */
    public function __construct(UserId $id, Email $email, DateTime $changedAt)
    {
        $this->email = $email;
        $this->id = $id;
        $this->changedAt = $changedAt;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /*
      * @return mixed The object instance
      */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Email::deserialize($data['email']),
                          DateTime::deserialize($data['changed_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'    => (string)$this->id,
            'email'      => $this->email->serialize(),
            'changed_at' => $this->changedAt->serialize()
        ];

    }

    /**
     * @return UserId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }
}