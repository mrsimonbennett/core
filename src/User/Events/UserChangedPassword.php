<?php
namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
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
     * @return array
     */
    public function serialize()
    {
        throw new \Exception('Not implemented [serialize] method');
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        throw new \Exception('Not implemented [deserialize] method');
    }
}