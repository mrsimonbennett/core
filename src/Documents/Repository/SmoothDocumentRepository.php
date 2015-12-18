<?php namespace FullRent\Core\Documents\Repository;

use FullRent\Core\Documents\Document;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothDocumentRepository
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class SmoothDocumentRepository extends EventSourcedRepository implements DocumentRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'document-';
    }

    /**
     * @return string
     */
    protected function getAggregateType()
    {
        return Document::class;
    }
}