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
            ->table('property_documents')
            ->where('property_id', $query->getPropertyId())
            ->get();

        if (empty($documents)) {
            throw new DocumentsNotFound("No documents found for property [{$query->getPropertyId()}]");
        }

        return $documents;
    }
}