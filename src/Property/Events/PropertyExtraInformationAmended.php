<?php
namespace FullRent\Core\Property\Events;

use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class PropertyExtraInformationAmended
 * @package FullRent\Core\Property\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyExtraInformationAmended implements Event, Serializable
{
    /** @var PropertyId */
    private $id;

    /** @var BedRooms */
    private $bedRooms;

    /** @var Bathrooms */
    private $bathrooms;

    /** @var Parking */
    private $parking;

    /** @var Pets */
    private $pets;

    /** @var DateTime */
    private $amendedAt;

    /**
     * PropertyExtraInformationAmended constructor.
     * @param PropertyId $id
     * @param BedRooms $bedRooms
     * @param Bathrooms $bathrooms
     * @param Parking $parking
     * @param Pets $pets
     * @param DateTime $amendedAt
     * @internal param DateTime $param
     */
    public function __construct(
        PropertyId $id,
        BedRooms $bedRooms,
        Bathrooms $bathrooms,
        Parking $parking,
        Pets $pets,
        DateTime $amendedAt
    ) {
        $this->id = $id;
        $this->bedRooms = $bedRooms;
        $this->bathrooms = $bathrooms;
        $this->parking = $parking;
        $this->pets = $pets;
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
     * @return BedRooms
     */
    public function getBedRooms()
    {
        return $this->bedRooms;
    }

    /**
     * @return Bathrooms
     */
    public function getBathrooms()
    {
        return $this->bathrooms;
    }

    /**
     * @return Parking
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * @return Pets
     */
    public function getPets()
    {
        return $this->pets;
    }

    /**
     * @return DateTime
     */
    public function getAmendedAt()
    {
        return $this->amendedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new PropertyId($data['id']),
            BedRooms::deserialize($data['bedrooms']),
            Bathrooms::deserialize($data['bathrooms']),
            Parking::deserialize($data['parking']),
            Pets::deserialize($data['pets']),
            DateTime::deserialize($data['amended_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'         => (string)$this->id,
            'bedrooms'   => $this->bedRooms->serialize(),
            'bathrooms'  => $this->bathrooms->serialize(),
            'parking'    => $this->parking->serialize(),
            'pets'       => $this->pets->serialize(),
            'amended_at' => $this->amendedAt->serialize(),
        ];

    }
}