<?php
namespace FullRent\Core\Property;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class Property
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class Property extends EventSourcedAggregateRoot
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


    public static function listNewProperty(
        PropertyId $propertyId,
        Address $address,
        Company $company,
        Landlord $landlord,
        BedRooms $bedRooms,
        Bathrooms $bathrooms,
        Parking $parking,
        Pets $pets
    ) {
        $property = new static();
        $property->apply(new NewPropertyListed($propertyId, $address, $company, $landlord, $bedRooms, $bathrooms,
            $parking, $pets, DateTime::now()));

        return $property;
    }

    public function applyNewPropertyListed(NewPropertyListed $newPropertyListed)
    {
        $this->propertyId = $newPropertyListed->getPropertyId();
        $this->address = $newPropertyListed->getAddress();
        $this->company = $newPropertyListed->getCompany();
        $this->landlord = $newPropertyListed->getLandlord();
        $this->bedRooms = $newPropertyListed->getBedRooms();
        $this->bathrooms = $newPropertyListed->getBathrooms();
        $this->parking = $newPropertyListed->getParking();
        $this->pets = $newPropertyListed->getPets();
        $this->listedAt = $newPropertyListed->getListedAt();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'property-' . (string)$this->propertyId;
    }
}