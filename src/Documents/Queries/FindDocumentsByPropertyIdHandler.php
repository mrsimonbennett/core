<?php namespace FullRent\Core\Documents\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Documents\Exception\DocumentsNotFound;

/**
 * Class FindDocumentsByPropertyIdHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindDocumentsByPropertyIdHandler
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
    public function handle(FindDocumentsByPropertyId $query)
    {
        $documents = $this->client
            ->query()
            ->table('documents')
            ->select('documents.*')
            ->join('property_documents', 'property_documents.document_id', '=', 'documents.document_id')
            ->where('property_documents.property_id', $query->getPropertyId())
            ->where('documents.deleted_at', NULL)
            ->orderBy('property_documents.attached_at', 'desc')
            ->limit(10)
            ->get();

        return $documents;
    }
}