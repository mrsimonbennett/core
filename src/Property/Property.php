<?php
namespace FullRent\Core\Property;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Property\Events\ApplicantInvitedToApplyByEmail;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;
use FullRent\Core\Property\Exceptions\PropertyAlreadyAcceptingApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyAlreadyClosedToApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyClosedToApplications;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\ApplicantEmail;
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
    private $id;
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
     * @var DateTime
     */
    private $acceptingApplicationsFrom = false;


    /**
     * @param PropertyId $propertyId
     * @param Address $address
     * @param Company $company
     * @param Landlord $landlord
     * @param BedRooms $bedRooms
     * @param Bathrooms $bathrooms
     * @param Parking $parking
     * @param Pets $pets
     * @return static
     */
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

    /**
     * @param DateTime $acceptingAt
     * @throws PropertyAlreadyAcceptingApplicationsException
     */
    public function acceptApplications(DateTime $acceptingAt = null)
    {
        if ($this->acceptingApplicationsFrom) {
            throw new PropertyAlreadyAcceptingApplicationsException();
        }

        if (is_null($acceptingAt)) {
            $acceptingAt = DateTime::now();
        }

        $this->apply(new PropertyAcceptingApplications($this->id, $acceptingAt));
    }

    public function closeApplications(DateTime $closedAt = null)
    {
        if (!$this->acceptingApplicationsFrom) {
            throw new PropertyAlreadyClosedToApplicationsException();
        }

        if (is_null($closedAt)) {
            $closedAt = DateTime::now();
        }

        $this->apply(new PropertyClosedAcceptingApplications($this->id, $closedAt));
    }

    /**
     * @param ApplicantEmail $applicantEmail
     * @throws PropertyClosedToApplications
     */
    public function emailApplication(ApplicantEmail $applicantEmail)
    {
        if (!$this->acceptingApplicationsFrom) {
            throw new PropertyClosedToApplications;
        }
        $this->apply(new ApplicantInvitedToApplyByEmail($this->id, $applicantEmail, DateTime::now()));
    }

    /**
     * @param NewPropertyListed $newPropertyListed
     */
    protected function applyNewPropertyListed(NewPropertyListed $newPropertyListed)
    {
        $this->id = $newPropertyListed->getPropertyId();
        $this->address = $newPropertyListed->getAddress();
        $this->company = $newPropertyListed->getCompany();
        $this->landlord = $newPropertyListed->getLandlord();
        $this->bedRooms = $newPropertyListed->getBedRooms();
        $this->bathrooms = $newPropertyListed->getBathrooms();
        $this->parking = $newPropertyListed->getParking();
        $this->pets = $newPropertyListed->getPets();
        $this->listedAt = $newPropertyListed->getListedAt();
    }

    protected function applyPropertyAcceptingApplications(PropertyAcceptingApplications $e)
    {
        $this->acceptingApplicationsFrom = true;
    }

    protected function applyPropertyClosedAcceptingApplications(PropertyClosedAcceptingApplications $e)
    {
        $this->acceptingApplicationsFrom = false;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'property-' . (string)$this->id;
    }


}