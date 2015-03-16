<?php
namespace FullRent\Core;

use Rhumsaa\Uuid\Uuid;

/**
 * Class UuidIdentity
 * @package Discuss
 * @author Simon Bennett <simon@bennett.im>
 */
abstract class UuidIdentity implements Identity
{
    /**
     * @var
     */
    protected $uuid;

    /**
     * @param $uuid
     */
    public function __construct($uuid)
    {
        $this->guardAgainstInvalidUUID($uuid);

        $this->uuid = $uuid;
    }

    /**
     * @param $string
     * @return static
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * @return UUID
     */
    public static function random()
    {
        return new static((string)Uuid::uuid4());
    }

    /**
     * @param Identity $other
     * @return Identity
     */
    public static function fromIdentity(Identity $other)
    {
        return new static((string)$other);
    }
    /**
     * @return string
     */
    function __toString()
    {
        return (string)$this->uuid;
    }

    /**
     * Test if ID matches another Id Object
     * @param Identity $other
     * @return bool
     */
    public function equal(Identity $other)
    {
        return $this == $other;
    }

    /**
     * @param string $uuid
     * @throws InvalidArgumentException
     */
    private function guardAgainstInvalidUUID($uuid)
    {
        if (!preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $uuid)) {
            throw new InvalidUuidException($uuid);
        }
    }


}