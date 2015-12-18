<?php namespace FullRent\Core\Property\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Property\ValueObjects\DocumentId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DocumentRemovedFromProperty
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentRemovedFromProperty implements Serializable, Event
{
    /** @var PropertyId */
    private $propertyId;

    /** @var DocumentId */
    private $documentId;

    /** @var DateTime */
    private $removedAt;

    /**
     * @param PropertyId $propertyId
     * @param DocumentId    $documentId
     * @param DateTime   $removedAt
     */
    public function __construct(PropertyId $propertyId, DocumentId $documentId, DateTime $removedAt)
    {
        $this->propertyId = $propertyId;
        $this->documentId = $documentId;
        $this->removedAt = $removedAt;
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
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => (string) $this->propertyId,
            'document_id' => (string) $this->documentId,
            'removed_at'  => $this->removedAt->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(
            new PropertyId($data['property_id']),
            new DocumentId($data['document_id']),
            DateTime::deserialize($data['removed_at'])
        );
    }
}