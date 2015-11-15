<?php namespace FullRent\Core\User\Commands;
use FullRent\Core\User\ValueObjects\UserId;
use FullRent\Core\ValueObjects\Timezone;

/**
 * Class ChangeUsersTimezone
 *
 * @package FullRent\Core\User\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ChangeUsersTimezone
{
    /** @var UserId  */
    private $userId;

    /** @var Timezone */
    private $timezone;

    /**
     * @param UserId $userId
     * @param Timezone $timezone
     */
    public function __construct(UserId $userId, Timezone $timezone)
    {
        $this->userId = $userId;
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
     * @return Timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}