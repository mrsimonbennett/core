<?php
namespace FullRent\Core\Application\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class PhoneNumber
 * @package FullRent\Core\Application\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class PhoneNumber implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @param string $phoneNumber
     */
    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->phoneNumber;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['phone']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['phone' => $this->phoneNumber];
    }
}