<?php namespace FullRent\Core\Documents\Commands;

use Illuminate\Contracts\Filesystem\Filesystem;
use FullRent\Core\Documents\Repository\DocumentRepository;

/**
 * Class UpdateDocumentHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdateDocumentHandler
{
    /** @var DocumentRepository */
    private $repository;

    /** @var Filesystem */
    private $filesystem;

    /**
     * @param DocumentRepository $repository
     * @param Filesystem         $filesystem
     */
    public function __construct(DocumentRepository $repository, Filesystem $filesystem)
    {
        $this->repository = $repository;
        $this->filesystem = $filesystem;
    }

    /**
     * @param UpdateDocument $command
     */
    public function handle(UpdateDocument $command)
    {
        $document = $this->repository->load($command->documentId());

        $document->changeName($command->newDocumentName());
        $document->changeExpiryDate($command->expiryDate());
        $document->addType($command->documentType());

        $this->repository->save($document);
    }
}