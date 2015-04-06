<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Property\PropertyRepository;

/**
 * Class CloseApplicationsHandler
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CloseApplicationsHandler implements CommandHandler
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
     * @param CloseApplications $command
     */
    public function handle(CloseApplications $command)
    {
        $property = $this->propertyRepository->load($command->getPropertyId());
        $property->closeApplications();
        $this->propertyRepository->save($property);
    }
}