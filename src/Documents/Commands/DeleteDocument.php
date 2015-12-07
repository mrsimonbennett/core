<?php namespace FullRent\Core\Documents\Commands;

use FullRent\Core\Documents\ValueObjects\DocumentId;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class DeleteDocument
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DeleteDocument extends BaseCommand
{
    /** @var DocumentId */
    private $documentId;

    /**
     * DeleteDocument constructor.
     *
     * @param string $documentId
     */
    public function __construct($documentId)
    {
        $this->documentId = new DocumentId($documentId);
    }

    /**
     * @return DocumentId
     */
    public function documentId()
    {
        return $this->documentId;
    }
}