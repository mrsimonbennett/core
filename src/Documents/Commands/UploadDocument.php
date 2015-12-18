<?php namespace FullRent\Core\Documents\Commands;

use SmoothPhp\CommandBus\BaseCommand;
use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploadDocument
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UploadDocument extends BaseCommand
{
    /** @var DocumentId */
    private $documentId;

    /** @var UploadedFile */
    private $uploadedDocument;

    /** @var DateTime */
    private $expiresAt;

    /**
     * @param string       $documentId
     * @param UploadedFile $uploadedDocument
     * @param DateTime     $expiresAt
     */
    public function __construct($documentId, UploadedFile $uploadedDocument, DateTime $expiresAt)
    {
        $this->documentId = new DocumentId($documentId);
        $this->uploadedDocument = $uploadedDocument;
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return DocumentId
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedDocument()
    {
        return $this->uploadedDocument;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }
}