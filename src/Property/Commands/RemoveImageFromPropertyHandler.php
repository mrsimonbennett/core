<?php namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\PropertyRepository;

/**
 * Class RemoveImageHandler
 * @package FullRent\Core\Property\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class RemoveImageFromPropertyHandler
{
    /** @var PropertyRepository */
    private $propertyRepository;

    /**
     * @param PropertyRepository $propertyRepository
     */
    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @param RemoveImageFromProperty $command
     */
    public function handle(RemoveImageFromProperty $command)
    {
        $property = $this->propertyRepository->load($command->getPropertyId());

        $property->removeImage($command->getImageId());

        $this->propertyRepository->save($property);
    }
}