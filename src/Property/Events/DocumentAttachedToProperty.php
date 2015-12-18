<?php namespace FullRent\Core\Property\Events;

use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Property\ValueObjects\DocumentId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DocumentAttachedToProperty
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentAttachedToProperty implements Serializable, Event
{
    /** @var PropertyId */
    private $propertyId;

    /** @var DocumentId */
    private $documentId;

    /** @var DateTime */
    private $attachedAt;

    /**
     * @param PropertyId $propertyId
     * @param DocumentId    $documentId
     * @param DateTime   $attachedAt
     */
    public function __construct(PropertyId $propertyId, DocumentId $documentId, DateTime $attachedAt)
    {
        $this->propertyId = $propertyId;
        $this->documentId = $documentId;
        $this->attachedAt = $attachedAt;
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

    /**
     * @return DateTime
     */
    public function wasAttachedAt()
    {
        return $this->attachedAt;
    }

    /**
     * @param array $data The serialized data
     * @return self The object instance
     */
    public static function deserialize(array $data)
    {
        return new self(
            new PropertyId($data['property_id']),
            new DocumentId($data['document_id']),
            DateTime::deserialize($data['attached_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => (string) $this->propertyId,
            'document_id' => (string) $this->documentId,
            'attached_at' => $this->attachedAt->serialize(),
        ];
    }
}