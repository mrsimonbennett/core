<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Documents\ValueObjects\DocumentName;

/**
 * Class DocumentNameChanged
 * @package FullRent\Core\Documents\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentNameChanged implements Serializable, Event
{
    /** @var DocumentId */
    private $documentId;

    /** @var DocumentName */
    private $newName;

    /** @var DateTime */
    private $changedAt;

    /**
     * DocumentNameChanged constructor.
     *
     * @param DocumentId   $documentId
     * @param DocumentName $newName
     * @param DateTime     $changedAt
     */
    public function __construct(DocumentId $documentId, DocumentName $newName, DateTime $changedAt)
    {
        $this->documentId = $documentId;
        $this->newName = $newName;
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
     * @return DocumentName
     */
    public function newName()
    {
        return $this->newName;
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
            'new_name'    => (string) $this->newName,
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
            new DocumentName($data['new_name']),
            DateTime::deserialize($data['changed_at'])
        );
    }
}