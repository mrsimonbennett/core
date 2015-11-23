<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\PropertyRepository;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class UpdatePropertiesBasicInformationHandler
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class UpdatePropertiesBasicInformationHandler
{
    /** @var PropertyRepository */
    private $propertyRepository;

    /**
     * UpdatePropertiesBasicInformationHandler constructor.
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function handle(UpdatePropertiesBasicInformation $command)
    {
        $property = $this->propertyRepository->load(new PropertyId($command->getPropertyId()));

        $property->amendAddress(new Address($command->getAddress(),
                                            $command->getCity(),
                                            $command->getCounty(),
                                            $command->getCountry(),
                                            $command->getPostcode()));


        $property->amendExtraInformation(new BedRooms($command->getBedroomCount()),
                                         new Bathrooms($command->getBathroomsCount()),
                                         new Parking($command->getParkingCount()),
                                         new Pets(true, false));

        $this->propertyRepository->save($property);
    }
}   