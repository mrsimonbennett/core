<?php namespace FullRent\Core\Documents\Events;

use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Documents\ValueObjects\DocumentName;
use FullRent\Core\Documents\ValueObjects\DocumentId;

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

    /**
     * DocumentNameChanged constructor.
     *
     * @param DocumentId $documentId
     * @param DocumentName $newName
     */
    public function __construct(DocumentId $documentId, DocumentName $newName)
    {
        $this->documentId = $documentId;
        $this->newName = $newName;
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
     * @return array
     */
    public function serialize()
    {
        return [
            'document_id' => (string) $this->documentId,
            'new_name'    => (string) $this->newName,
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new self(new DocumentId($data['document_id'], new DocumentName($data['new_name'])));
    }
}