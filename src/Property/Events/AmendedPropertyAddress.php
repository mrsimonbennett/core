<?php
namespace FullRent\Core\Property\Events;

use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class AmendedPropertyAddress
 * @package FullRent\Core\Property\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class AmendedPropertyAddress implements Serializable, Event
{
    /** @var PropertyId */
    private $id;

    /** @var Address */
    private $address;

    /** @var DateTime */
    private $amendedAt;

    /**
     * AmendedPropertyAddress constructor.
     * @param PropertyId $id
     * @param Address $address
     * @param DateTime $amendedAt
     */
    public function __construct(PropertyId $id, Address $address, DateTime $amendedAt)
    {
        $this->id = $id;
        $this->address = $address;
        $this->amendedAt = $amendedAt;
    }

    /**
     * @return PropertyId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return DateTime
     */
    public function getAmendedAt()
    {
        return $this->amendedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'         => (string)$this->id,
            'address'    => $this->address->serialize(),
            'amended_at' => $this->amendedAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new PropertyId($data['id']),
                          Address::deserialize($data['address']),
                          DateTime::deserialize($data['amended_at']));
    }
}