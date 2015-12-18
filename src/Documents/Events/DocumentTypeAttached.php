<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Documents\ValueObjects\DocumentType;

/**
 * Class DocumentTypeAttached
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentTypeAttached implements Serializable, Event
{
    /** @var DocumentId */
    private $documentId;

    /** @var DocumentType */
    private $documentType;

    /** @var DateTime */
    private $attachedAt;

    /**
     * @param DocumentId   $documentId
     * @param DocumentType $documentType
     * @param DateTime     $attachedAt
     */
    public function __construct(
        DocumentId $documentId,
        DocumentType $documentType,
        DateTime $attachedAt
    ) {
        $this->documentId   = $documentId;
        $this->documentType = $documentType;
        $this->attachedAt   = $attachedAt;
    }

    /**
     * @return DocumentId
     */
    public function documentId()
    {
        return $this->documentId;
    }

    /**
     * @return DocumentType
     */
    public function documentType()
    {
        return $this->documentType;
    }

    /**
     * @return DateTime
     */
    public function wasAttachedAt()
    {
        return $this->attachedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new DocumentId($data['document_id']),
            new DocumentType($data['document_type']),
            DateTime::deserialize($data['attached_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id'   => (string) $this->documentId,
            'document_type' => (string) $this->documentType,
            'attached_at'   => $this->attachedAt->serialize(),
        ];
    }
}