<?php
namespace FullRent\Core\Property\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class UpdatePropertiesBasicInformation
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class UpdatePropertiesBasicInformation extends BaseCommand
{
    /** @var string|string */
    private $propertyId;

    /** @var string */
    private $address;

    /** @var string */
    private $city;

    /** @var string */
    private $county;

    /** @var string */
    private $country;

    /** @var string */
    private $postcode;

    /** @var string */
    private $bedroomCount;

    /** @var string */
    private $bathroomsCount;

    /** @var string */
    private $parkingCount;

    /** @var string */
    private $pets;

    /**
     * UpdatePropertiesBasicInformation constructor.
     * @param string $propertyId
     * @param string $address
     * @param string $city
     * @param string $county
     * @param string $country
     * @param string $postcode
     * @param string $bedroomCount
     * @param string $bathroomsCount
     * @param string $parkingCount
     * @param string $pets
     */
    public function __construct(
        $propertyId,
        $address,
        $city,
        $county,
        $country,
        $postcode,
        $bedroomCount,
        $bathroomsCount,
        $parkingCount,
        $pets
    ) {
        $this->propertyId = $propertyId;
        $this->address = $address;
        $this->city = $city;
        $this->county = $county;
        $this->country = $country;
        $this->postcode = $postcode;
        $this->bedroomCount = $bedroomCount;
        $this->bathroomsCount = $bathroomsCount;
        $this->parkingCount = $parkingCount;
        $this->pets = $pets;
    }

    /**
     * @return string
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getBedroomCount()
    {
        return $this->bedroomCount;
    }

    /**
     * @return string
     */
    public function getBathroomsCount()
    {
        return $this->bathroomsCount;
    }

    /**
     * @return string
     */
    public function getParkingCount()
    {
        return $this->parkingCount;
    }

    /**
     * @return string
     */
    public function getPets()
    {
        return $this->pets;
    }

}