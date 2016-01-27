<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Property\Property;
use FullRent\Core\Property\PropertyRepository;

/**
 * Class ListNewPropertyHandler
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ListNewPropertyHandler
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @param ListNewProperty $listNewProperty
     */
    public function handle(ListNewProperty $listNewProperty)
    {
        $property = Property::listNewProperty($listNewProperty->getPropertyId(), $listNewProperty->getAddress(),
            $listNewProperty->getCompany(), $listNewProperty->getLandlord(), $listNewProperty->getBedRooms(),
            $listNewProperty->getBathrooms(), $listNewProperty->getParking(), $listNewProperty->getPets());
        $this->propertyRepository->save($property);
    }

}