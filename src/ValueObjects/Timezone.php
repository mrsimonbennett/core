<?php namespace FullRent\Core\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Timezone
 *
 * @package FullRent\Core\ValueObjects
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Timezone implements SerializableInterface
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
}