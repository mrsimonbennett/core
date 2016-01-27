<?php namespace FullRent\Core\User\Events;

use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UserHasUpdatedSettings
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UserHasUpdatedSettings implements Serializable, Event
{
    /** @var UserId */
    private $userId;

    /** @var array */
    private $settings;

    /** @var DateTime */
    private $updatedAt;

    /**
     * UserHasUpdatedSettings constructor.
     *
     * @param UserId   $userId
     * @param array    $settings
     * @param DateTime $updatedAt
     */
    public function __construct(UserId $userId, array $settings, DateTime $updatedAt)
    {
        $this->userId = $userId;
        $this->settings = $settings;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @return array
     */
    public function settings()
    {
        return $this->settings;
    }

    /**
     * @return DateTime
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'user_id'    => (string) $this->userId,
            'settings'   => $this->settings,
            'updated_at' => $this->updatedAt->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(
            new UserId($data['user_id']),
            $data['settings'],
            DateTime::deserialize($data['updated_at'])
        );
    }
}