<?php
namespace FullRent\Core;

use Rhumsaa\Uuid\Uuid;
/**
 * Class UuidIdentity
 * @package Discuss
 * @author Simon Bennett <simon@bennett.im>
 */
interface Identity
{
    /**
     * @param $uuid
     */
    public function __construct($uuid);

    /**
     * @param $string
     * @return static
     */
    public static function fromString($string);

    /**
     * @return UUID
     */
    public static function random();

    /**
     * @return string
     */
    function __toString();

    /**
     * Test if ID matches another Id Object
     * @param Identity $other
     * @return bool
     */
    public function equal(Identity $other);

    /**
     * @param Identity $other
     * @return Identity
     */
    public static function fromIdentity(Identity $other);
}