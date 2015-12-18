<?php namespace FullRent\Core\Documents\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentId;

/**
 * Class DocumentTrashed
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentMovedToTrash implements Serializable, Event
{
    /** @var DocumentId */
    private $documentId;

    /** @var DateTime */
    private $trashedAt;

    /**
     * @param DocumentId   $documentId
     * @param DateTime     $trashedAt
     */
    public function __construct(
        DocumentId $documentId,
        DateTime $trashedAt
    ) {
        $this->documentId = $documentId;
        $this->trashedAt  = $trashedAt;
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
    public function trashedAt()
    {
        return $this->trashedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new DocumentId($data['document_id']),
            DateTime::deserialize($data['trashed_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id'   => (string) $this->documentId,
            'trashed_at'   => $this->trashedAt->serialize(),
        ];
    }
}