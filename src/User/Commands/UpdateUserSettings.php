<?php namespace FullRent\Core\User\Commands;

use FullRent\Core\User\ValueObjects\UserId;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class UpdateUserSettings
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdateUserSettings extends BaseCommand
{
    /** @var UserId */
    private $userId;

    /** @var array */
    private $settings;

    /**
     * UpdateUserSettings constructor.
     *
     * @param       $userId
     * @param array $settings
     */
    public function __construct($userId, array $settings)
    {
        $this->userId   = new UserId($userId);
        $this->settings = $settings;
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
}