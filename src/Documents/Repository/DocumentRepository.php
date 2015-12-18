<?php namespace FullRent\Core\Documents\Repository;

use FullRent\Core\Documents\Document;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;
use FullRent\Core\Documents\ValueObjects\DocumentId;

/**
 * Interface DocumentRepository
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
interface DocumentRepository
{
    /**
     * @param DocumentId $id
     * @return Document
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}