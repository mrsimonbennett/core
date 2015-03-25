<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\Company;
use FullRent\Core\Property\Landlord;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\LandlordId;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class ListNewProperty
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ListNewProperty
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
     * @param Address $address
     * @param CompanyId $companyId
     * @param LandlordId $landlordId
     * @param BedRooms $bedRooms
     * @param Bathrooms $bathrooms
     * @param Parking $parking
     * @param Pets $pets
     */
    public function __construct(
        Address $address,
        CompanyId $companyId,
        LandlordId $landlordId,
        BedRooms $bedRooms,
        Bathrooms $bathrooms,
        Parking $parking,
        Pets $pets
    ) {
        $this->propertyId = PropertyId::random();
        $this->address = $address;
        $this->company = new Company($companyId);
        $this->landlord = new Landlord($landlordId);
        $this->bedRooms = $bedRooms;
        $this->bathrooms = $bathrooms;
        $this->parking = $parking;
        $this->pets = $pets;
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

}