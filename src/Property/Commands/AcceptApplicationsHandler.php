<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Property\PropertyRepository;

/**
 * Class AcceptApplicationsHandler
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AcceptApplicationsHandler
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
     * @param AcceptApplications $command
     * @throws \FullRent\Core\Property\Exceptions\PropertyAlreadyAcceptingApplicationsException
     */
    public function handle(AcceptApplications $command)
    {
        $property = $this->propertyRepository->load($command->getPropertyId());

        $property->acceptApplications();

        $this->propertyRepository->save($property);
    }
}