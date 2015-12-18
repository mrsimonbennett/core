<?php namespace FullRent\Core\Documents\Commands;

use League\Flysystem\Filesystem;
use FullRent\Core\Documents\Document;
use League\Flysystem\AdapterInterface;
use FullRent\Core\Documents\Storage\DocumentStore;
use FullRent\Core\Documents\Repository\DocumentRepository;

/**
 * Class UploadDocumentHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UploadDocumentHandler
{
    /** @var DocumentRepository */
    private $repository;

    /** @var DocumentStore */
    private $store;

    /**
     * @param DocumentRepository $repository
     * @param DocumentStore      $store
     */
    public function __construct(DocumentRepository $repository, DocumentStore $store)
    {
        $this->repository = $repository;
        $this->store = $store;
    }

    /**
     * @param UploadDocument $command
     */
    public function handle(UploadDocument $command)
    {
        $document = Document::upload(
            $command->getDocumentId(),
            $command->getUploadedDocument(),
            $command->getExpiresAt(),
            $this->store
        );

        $this->repository->save($document);
    }
}