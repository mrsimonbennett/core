<?php namespace FullRent\Core\Property\Commands;

use SmoothPhp\CommandBus\BaseCommand;
use FullRent\Core\Property\ValueObjects\DocumentId;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class AttachImage
 *
 * @package FullRent\Core\Property\Commands
 * @author  jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class AttachDocument extends BaseCommand
{
    /** @var PropertyId */
    private $propertyId;

    /** @var DocumentId */
    private $documentId;

    /**
     * @param string $propertyId
     * @param string $documentId
     */
    public function __construct($propertyId, $documentId)
    {
        $this->propertyId = new PropertyId($propertyId);
        $this->documentId = new DocumentId($documentId);
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return DocumentId
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }
}