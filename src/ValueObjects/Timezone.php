<?php namespace FullRent\Core\ValueObjects;

<<<<<<< HEAD
use SmoothPhp\Contracts\Serialization\Serializable;
=======
use Broadway\Serializer\SerializableInterface;
>>>>>>> feature/user-settings

/**
 * Class Timezone
 *
 * @package FullRent\Core\ValueObjects
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
<<<<<<< HEAD
final class Timezone implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
=======
final class Timezone implements SerializableInterface
>>>>>>> feature/user-settings
{
    /** @var string */
    private $timezone;

    /**
     * @param string $timezone
     */
    public function __construct($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @param array $data
     * @return Timezone
     */
    public static function deserialize(array $data)
    {
        return new Timezone($data['timezone']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['timezone' => $this->timezone];
    }
<<<<<<< HEAD

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->timezone;
    }
=======
>>>>>>> feature/user-settings
}