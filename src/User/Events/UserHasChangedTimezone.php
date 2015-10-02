<?php namespace FullRent\Core\User\Events;

use FullRent\Core\ValueObjects\Timezone;

/**
 * Class UserHasChangedTimezone
 *
 * @package FullRent\Core\User\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UserHasChangedTimezone
{
    /** @var Timezone */
    private $timezone;

    /**
     * @param Timezone $timezone
     */
    public function __construct(Timezone $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return Timezone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}