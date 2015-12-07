<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UserAmendedName
 * @package FullRent\Core\User\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserAmendedName implements Serializable, Event
{
    /** @var UserId */
    private $userId;

    /** @var Name */
    private $name;

    /** @var DateTime */
    private $amendedAt;

    /**
     * UserAmendedName constructor.
     * @param UserId $userId
     * @param Name $name
     * @param  DateTime $amendedAt
     */
    public function __construct(UserId $userId, Name $name, DateTime $amendedAt)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->amendedAt = $amendedAt;
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
     * @return DateTime
     */
    public function getAmendedAt()
    {
        return $this->amendedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new UserId($data['user_id']),
                          Name::deserialize($data['name']),
                          DateTime::deserialize($data['amended_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'    => (string)$this->userId,
            'name'       => $this->name->serialize(),
            'amended_at' => $this->amendedAt->serialize()
        ];
    }
}