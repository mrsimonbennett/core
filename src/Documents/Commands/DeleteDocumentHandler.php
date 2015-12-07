<?php namespace FullRent\Core\Documents\Commands;

use FullRent\Core\Documents\Repository\DocumentRepository;

/**
 * Class DeleteDocumentHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class DeleteDocumentHandler
{
    /** @var DocumentRepository */
    private $repository;

    /**
     * DeleteDocumentHandler constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DeleteDocument $command)
    {
        $document = $this->repository->load($command->documentId());
        $document->trash();

        $this->repository->save($document);
    }
}