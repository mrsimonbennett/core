<?php namespace FullRent\Core\Documents\Listeners;

use FullRent\Core\Documents\Events\DocumentStored;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class DocumentsMysqlListener
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DocumentsMysqlListener implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * DocumentsMysqlListener constructor.
     *
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param DocumentStored $e
     */
    public function whenDocumentStored(DocumentStored $e)
    {
        $this->client->query()
                     ->table('documents')
                     ->insert([
                             'document_id'                      => $e->getDocumentId(),
                             'name'                             => $e->getDocumentName(),
                             'uploaded_at'                      => $e->getUploadedAt(),
                         ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            DocumentStored::class => ['whenDocumentStored'],
        ];
    }
}