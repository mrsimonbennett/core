<?php namespace FullRent\Core\Documents\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Documents\Exception\DocumentsNotFound;

/**
 * Class FindDeletedDocumentsByPropertyIdHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindDeletedDocumentsByPropertyIdHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindDocumentsByPropertyId $query
     * @return array
     */
    public function handle(FindDeletedDocumentsByPropertyId $query)
    {
        $documents = $this->client
            ->query()
            ->table('documents')
            ->select('documents.*')
            ->join('property_documents', 'property_documents.document_id', '=', 'documents.document_id')
            ->where('property_documents.property_id', $query->propertyId())
            ->whereNotNull('documents.deleted_at')
            ->get();

        \Log::debug('Deleted docs: ' . count($documents));

        return $documents;
    }
}