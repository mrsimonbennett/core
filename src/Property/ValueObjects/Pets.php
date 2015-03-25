<?php
namespace FullRent\Core\Property\ValueObjects;

use Broadway\Serializer\SerializableInterface;

/**
 * Class Pets
 * @package FullRent\Core\Property\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class Pets implements SerializableInterface
{
    /**
     * @var bool
     */
    private $allowed;
    /**
     * @var bool
     */
    private $permissionRequired;

    /**
     * @param bool $allowed
     * @param bool $permissionRequired
     */
    public function __construct($allowed, $permissionRequired)
    {
        $this->allowed = $allowed;
        $this->permissionRequired = $permissionRequired;
    }

    /**
     * @return static
     */
    public static function allowed()
    {
        return new static(true, false);
    }

    /**
     * @return static
     */
    public static function allowedWithPermission()
    {
        return new static(true, true);
    }

    /**
     * @return static
     */
    public static function notAllowed()
    {
        return new static(false, false);
    }

    /**
     * @return boolean
     */
    public function isAllowed()
    {
        return $this->allowed;
    }

    /**
     * @return boolean
     */
    public function isPermissionRequired()
    {
        return $this->permissionRequired;
    }


    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['allowed'], $data['permission-required']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['allowed' => $this->allowed, 'permission-required' => $this->permissionRequired];
    }
}