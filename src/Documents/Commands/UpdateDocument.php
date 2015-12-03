<?php namespace FullRent\Core\Documents\Commands;

use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Images\ValueObjects\DocumentName;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\CommandBus\BaseCommand;

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

    /**
     * TODO: Need a nicer way of figuring out the date format
     *
     * @param $documentId
     * @param $name
     * @param $expiryDate
     */
    public function __construct($documentId, $name, $expiryDate)
    {
        $this->documentId = new DocumentId($documentId);
        $this->name       = new DocumentName($name);
        $this->expiryDate = DateTime::createFromFormat('d/m/Y', $expiryDate);
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
     * @return DateTime
     */
    public function expiryDate()
    {
        return $this->expiryDate;
    }
}