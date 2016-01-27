<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\PropertyRepository;
use FullRent\Core\Property\ValueObjects\ApplicantEmail;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class EmailApplicationHandler
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EmailApplicationHandler
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
     * @param EmailApplication $command
     * @throws \FullRent\Core\Property\Exceptions\PropertyClosedToApplications
     */
    public function handle(EmailApplication $command)
    {
        $property = $this->propertyRepository->load(new PropertyId($command->getPropertyId()));

        $property->emailApplication(new ApplicantEmail($command->getApplicantEmail()));

        $this->propertyRepository->save($property);
    }
}