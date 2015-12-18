<?php namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\ValueObjects\DocumentId;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class DocumentAttachedToTenancy
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentAttachedToTenancy implements Serializable, Event
{
    /** @var TenancyId */
    private $tenancyId;

    /** @var DocumentId */
    private $documentId;

    /** @var DateTime */
    private $attachedAt;

    /**
     * @param TenancyId $tenancyId
     * @param DocumentId $documentId
     * @param DateTime   $attachedAt
     */
    public function __construct(TenancyId $tenancyId, DocumentId $documentId, DateTime $attachedAt)
    {
        $this->tenancyId = $tenancyId;
        $this->documentId = $documentId;
        $this->attachedAt = $attachedAt;
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
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
            new TenancyId($data['tenancy_id']),
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
            'tenancy_id' => (string) $this->tenancyId,
            'document_id' => (string) $this->documentId,
            'attached_at' => $this->attachedAt->serialize(),
        ];
    }
}