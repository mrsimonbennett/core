<?php namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\PropertyRepository;

/**
 * Class AttachDocumentHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class AttachDocumentHandler
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
     * @param AttachDocument $command
     */
    public function handle(AttachDocument $command)
    {
        $property = $this->propertyRepository->load($command->getPropertyId());

        $property->attachDocument($command->getDocumentId());

        $this->propertyRepository->save($property);
    }
}