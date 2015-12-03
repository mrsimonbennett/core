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

    /**
     * DocumentNameChanged constructor.
     *
     * @param DocumentId $documentId
     * @param DateTime   $newExpiryDate
     */
    public function __construct(DocumentId $documentId, DateTime $newExpiryDate)
    {
        $this->documentId    = $documentId;
        $this->newExpiryDate = $newExpiryDate;
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
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id' => (string) $this->documentId,
            'expiry_date' => $this->newExpiryDate->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new self(new DocumentId($data['document_id'], DateTime::deserialize($data['expiry_date'])));
    }
}