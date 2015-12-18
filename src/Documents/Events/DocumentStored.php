<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\Documents\ValueObjects\DocumentExtension;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Documents\ValueObjects\DocumentName;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentId;

/**
 * Class UploadedImageStored
 *
 * @package FullRent\Core\Images\Events
 * @author  jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentStored implements Serializable, Event
{
    /** @var DocumentId */
    private $documentId;

    /** @var DocumentName */
    private $documentName;

    /** @var DateTime */
    private $expiresAt;

    /** @var DateTime */
    private $uploadedAt;

    /**
     * @param DocumentId   $documentId
     * @param DocumentName $documentName
     * @param DateTime     $expiresAt
     * @param DateTime     $uploadedAt
     */
    public function __construct(DocumentId $documentId, DocumentName $documentName, DateTime $expiresAt, DateTime $uploadedAt)
    {
        $this->documentId = $documentId;
        $this->uploadedAt = $uploadedAt;
        $this->documentName = $documentName;
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
     * @return DocumentName
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @return DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @return DocumentExtension
     */
    public function getDocumentExtension()
    {
        $parts = explode('.', (string) $this->documentName);
        return new DocumentExtension(count($parts) > 1 ? end($parts) : '');
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new DocumentId($data['document_id']),
            new DocumentName($data['document_name']),
            DateTime::deserialize($data['expires_at']),
            DateTime::deserialize($data['uploaded_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id'    => (string) $this->documentId,
            'document_name'  => (string) $this->documentName,
            'expires_at'     => $this->expiresAt->serialize(),
            'uploaded_at'    => $this->uploadedAt->serialize(),
        ];
    }
}