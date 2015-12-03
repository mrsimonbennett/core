<?php namespace FullRent\Core\Documents\Listeners;

use FullRent\Core\Documents\Events\DocumentStored;
use FullRent\Core\Documents\Events\DocumentTypeAttached;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;
use FullRent\Core\Documents\Events\DocumentNameChanged;
use FullRent\Core\Documents\Events\DocumentExpiryDateChanged;

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
     * @param DocumentNameChanged $e
     */
    public function whenDocumentNameChanged(DocumentNameChanged $e)
    {
        $this->client
             ->query()
             ->table('documents')
             ->where('document_id', $e->documentId())
             ->update([
                 'name' => $e->newName(),
             ]);
    }

    /**
     * @param DocumentExpiryDateChanged $e
     */
    public function whenDocumentExpiryDateChanged(DocumentExpiryDateChanged $e)
    {
        $this->client
             ->query()
             ->table('documents')
             ->where('document_id', $e->documentId())
             ->update([
                 'expires_at' => $e->newExpiryDate(),
             ]);
    }

    /**
     * @param DocumentTypeAttached $e
     */
    public function whenDocumentTypeAttached(DocumentTypeAttached $e)
    {
        $this->client
            ->query()
            ->table('documents')
            ->where('document_id', $e->documentId())
            ->update([
                    'type' => $e->documentType(),
            ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            DocumentStored::class            => ['whenDocumentStored'],
            DocumentNameChanged::class       => ['whenDocumentNameChanged'],
            DocumentExpiryDateChanged::class => ['whenDocumentExpiryDateChanged'],
            DocumentTypeAttached::class      => ['whenDocumentTypeAttached'],
        ];
    }
}