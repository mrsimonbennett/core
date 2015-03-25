<?php
namespace FullRent\Core\Property\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Property\Company;
use FullRent\Core\Property\Landlord;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class NewPropertyListed
 * @package FullRent\Core\Property\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class NewPropertyListed implements SerializableInterface
{
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var Address
     */
    private $address;
    /**
     * @var Company
     */
    private $company;
    /**
     * @var Landlord
     */
    private $landlord;
    /**
     * @var BedRooms
     */
    private $bedRooms;
    /**
     * @var Bathrooms
     */
    private $bathrooms;
    /**
     * @var Parking
     */
    private $parking;
    /**
     * @var Pets
     */
    private $pets;
    /**
     * @var DateTime
     */
    private $listedAt;

    /**
     * @param PropertyId $propertyId
     * @param Address $address
     * @param Company $company
     * @param Landlord $landlord
     * @param BedRooms $bedRooms
     * @param Bathrooms $bathrooms
     * @param Parking $parking
     * @param Pets $pets
     * @param DateTime $listedAt
     */
    public function __construct(
        PropertyId $propertyId,
        Address $address,
        Company $company,
        Landlord $landlord,
        BedRooms $bedRooms,
        Bathrooms $bathrooms,
        Parking $parking,
        Pets $pets,
        DateTime $listedAt
    ) {

        $this->propertyId = $propertyId;
        $this->address = $address;
        $this->company = $company;
        $this->landlord = $landlord;
        $this->bedRooms = $bedRooms;
        $this->bathrooms = $bathrooms;
        $this->parking = $parking;
        $this->pets = $pets;
        $this->listedAt = $listedAt;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return Landlord
     */
    public function getLandlord()
    {
        return $this->landlord;
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
    public function getListedAt()
    {
        return $this->listedAt;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new PropertyId($data['id']),
            Address::deserialize($data['address']),
            Company::deserialize($data['company']),
            Landlord::deserialize($data['landlord']),
            BedRooms::deserialize($data['bedrooms']),
            Bathrooms::deserialize($data['bathrooms']),
            Parking::deserialize($data['parking']),
            Pets::deserialize($data['pets']),
            DateTime::deserialize($data['listed_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => (string)$this->propertyId,
            'landlord' => $this->landlord->serialize(),
            'company' => $this->company->serialize(),
            'address' => $this->address->serialize(),
            'bedrooms' => $this->bedRooms->serialize(),
            'bathrooms' => $this->bathrooms->serialize(),
            'parking' => $this->parking->serialize(),
            'pets' => $this->pets->serialize(),
            'listed_at' => $this->listedAt->serialize(),
        ];

    }
}