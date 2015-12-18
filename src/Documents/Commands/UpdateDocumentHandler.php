<?php namespace FullRent\Core\Documents\Commands;

use Log;
use Illuminate\Contracts\Filesystem\Filesystem;
use FullRent\Core\Documents\Repository\DocumentRepository;
use FullRent\Core\Documents\Exception\DocumentTypeImmutable;

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

        try {
            $document->addType($command->documentType());
        } catch (DocumentTypeImmutable $e) {
            Log::debug("Attempt to change document type [{$command->documentId()}]");
        }

        $this->repository->save($document);
    }
}