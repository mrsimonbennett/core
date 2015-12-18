<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentId;

/**
 * Class DocumentExpiryDateChanged
 * @package FullRent\Core\Documents\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
class DocumentExpiryDateChanged implements Serializable, Event
{
    /** @var DocumentId */
    private $documentId;

    /** @var DateTime */
    private $newExpiryDate;

    /** @var DateTime */
    private $changedAt;

    /**
     * DocumentNameChanged constructor.
     *
     * @param DocumentId $documentId
     * @param DateTime   $newExpiryDate
     * @param DateTime   $changedAt
     */
    public function __construct(DocumentId $documentId, DateTime $newExpiryDate, DateTime $changedAt)
    {
        $this->documentId    = $documentId;
        $this->newExpiryDate = $newExpiryDate;
        $this->changedAt = $changedAt;
    }

    /**
     * @return DocumentId
     */
    public function documentId()
    {
        return $this->documentId;
    }

    /**
     * @return DateTime
     */
    public function newExpiryDate()
    {
        return $this->newExpiryDate;
    }

    /**
     * @return DateTime
     */
    public function changedAt()
    {
        return $this->changedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id' => (string) $this->documentId,
            'expiry_date' => $this->newExpiryDate->serialize(),
            'changed_at'  => $this->changedAt->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new self(
            new DocumentId($data['document_id']),
            DateTime::deserialize($data['expiry_date']),
            DateTime::deserialize($data['changed_at'])
        );
    }
}