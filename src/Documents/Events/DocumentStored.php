<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\Images\ValueObjects\DocumentName;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use SmoothPhp\Contracts\Serialization\Serializable;

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
    private $uploadedAt;

    /**
     * @param DocumentId   $documentId
     * @param DocumentName $documentName
     * @param DateTime     $uploadedAt
     */
    public function __construct(DocumentId $documentId, DocumentName $documentName, DateTime $uploadedAt)
    {
        $this->documentId = $documentId;
        $this->uploadedAt = $uploadedAt;
        $this->documentName = $documentName;
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
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new DocumentId($data['document_id']),
            new DocumentName($data['document_name']),
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
            'uploaded_at'    => $this->uploadedAt->serialize(),
        ];
    }
}