<?php namespace FullRent\Core\Documents\Commands;

use SmoothPhp\CommandBus\BaseCommand;
use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Documents\ValueObjects\DocumentName;
use FullRent\Core\Documents\ValueObjects\DocumentType;

/**
 * Class UpdateDocument
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdateDocument extends BaseCommand
{
    /** @var DocumentId */
    private $documentId;

    /** @var DocumentName */
    private $name;

    /** @var DateTime */
    private $expiryDate;

    /** @var DocumentType */
    private $type;

    /**
     * TODO: Need a nicer way of figuring out the date format
     *
     * @param string $documentId
     * @param string $name
     * @param string $expiryDate
     * @param string $type
     */
    public function __construct($documentId, $name, $expiryDate, $type)
    {
        $this->documentId = new DocumentId($documentId);
        $this->name       = new DocumentName($name);
        $this->expiryDate = DateTime::createFromFormat('d/m/Y', $expiryDate);
        $this->type       = new DocumentType($type);
    }

    /**
     * @return DocumentId
     */
    public function documentId()
    {
        return $this->documentId;
    }

    /**
     * @return DocumentName
     */
    public function newDocumentName()
    {
        return $this->name;
    }

    /**
     * @return DocumentType
     */
    public function documentType()
    {
        return $this->type;
    }

    /**
     * @return DateTime
     */
    public function expiryDate()
    {
        return $this->expiryDate;
    }
}