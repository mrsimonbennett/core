<?php
namespace FullRent\Core\Property;

use FullRent\Core\Property\Entity\InventoryItem;
use FullRent\Core\Property\Events\AmendedPropertyAddress;
use FullRent\Core\Property\Events\InventoryItemAdded;
use FullRent\Core\Property\Events\PropertyExtraInformationAmended;
use FullRent\Core\Property\Events\ApplicantInvitedToApplyByEmail;
use FullRent\Core\Property\Events\ImageAttachedToProperty;
use FullRent\Core\Property\Events\ImageRemovedFromProperty;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;
use FullRent\Core\Property\Exceptions\ImageAlreadyAdded;
use FullRent\Core\Property\Exceptions\PropertyAlreadyAcceptingApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyAlreadyClosedToApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyClosedToApplications;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\ApplicantEmail;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\ImageId;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemDescription;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemId;
use FullRent\Core\Property\ValueObjects\Inventory\InventoryItemName;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Property
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class Property extends AggregateRoot
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

    /** @var ImageId[] */
    private $images = [];

    /** @var Entity\InventoryItem[] */
    private $inventory = [];


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
     * @param ImageId $newImageId
     * @throws ImageAlreadyAdded
     */
    public function attachImage(ImageId $newImageId)
    {
        foreach ($this->images as $imageId) {
            if ($imageId->equal($newImageId)) {
                throw new ImageAlreadyAdded('This image has already been added to the property');
            }
        }

        $this->apply(new ImageAttachedToProperty($this->id, $newImageId, DateTime::now()));
    }

    /**
     * @param ImageId $imageId
     * @throws \Exception
     */
    public function removeImage(ImageId $imageId)
    {
        $filtered = array_filter($this->images, function (ImageId $existingImageId) use ($imageId) {
            return $existingImageId->equal($imageId);
        });

        if (count($filtered) > 1) {
            throw new \Exception('This image has been loaded more than once. Oopsie.');
        } elseif (count($filtered) < 1) {
            throw new \Exception('No image with this ID exists on property');
        }

        $this->apply(new ImageRemovedFromProperty($this->id, $imageId, DateTime::now()));
    }

    /**
     * @param Address $address
     */
    public function amendAddress(Address $address)
    {
        $this->apply(new AmendedPropertyAddress($this->id, $address, new DateTime()));
    }

    /**
     * @param BedRooms $bedRooms
     * @param Bathrooms $bathrooms
     * @param Parking $parking
     * @param Pets $pets
     */
    public function amendExtraInformation(BedRooms $bedRooms, Bathrooms $bathrooms, Parking $parking, Pets $pets)
    {
        $this->apply(new PropertyExtraInformationAmended($this->id, $bedRooms, $bathrooms, $parking, $pets, new DateTime()));
    }

    /**
     * @param InventoryItemId          $id
     * @param InventoryItemName        $name
     * @param InventoryItemDescription $description
     */
    public function addInventoryItem(InventoryItemId $id, InventoryItemName $name, InventoryItemDescription $description)
    {
        $this->apply(new InventoryItemAdded($this->id, $id, $name, $description));
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
     * @param ImageAttachedToProperty $e
     */
    protected function applyImageAttachedToProperty(ImageAttachedToProperty $e)
    {
        $this->images[] = $e->getImageId();
    }

    /**
     * @param ImageRemovedFromProperty $e
     */
    protected function applyImageRemovedFromProperty(ImageRemovedFromProperty $e)
    {
        $this->images = array_filter($this->images, function (ImageId $imageId) use ($e) {
            return !$imageId->equal($e->getImageId());
        });
    }

    /**
     * @param InventoryItemAdded $e
     */
    protected function applyInventoryItemAdded(InventoryItemAdded $e)
    {
        $this->id = $e->getPropertyId();

        $this->inventory[] = InventoryItem::forProperty(
            $e->getPropertyId(),
            $e->getItemId(),
            $e->getName(),
            $e->getDescription()
        );
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'property-' . (string)$this->id;
    }

    /**
     * @return Entity\InventoryItem[]
     */
    public function getChildren()
    {
        return $this->inventory;
    }
}