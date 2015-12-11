<?php namespace FullRent\Core\Documents\Commands;

use FullRent\Core\Documents\Document;
use Illuminate\Contracts\Filesystem\Filesystem;
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
     * @param UploadDocument $command
     */
    public function handle(UploadDocument $command)
    {
        $document = Document::upload(
            $command->getDocumentId(),
            $command->getUploadedDocument(),
            $command->getExpiresAt(),
            $this->filesystem
        );

        $this->repository->save($document);
    }
}