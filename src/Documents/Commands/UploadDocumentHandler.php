<?php namespace FullRent\Core\Documents\Commands;

use FullRent\Core\Documents\Document;
use Samcrosoft\Cloudinary\Wrapper\CloudinaryWrapper;
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

    /** @var CloudinaryWrapper */
    private $cloud;

    /**
     * @param DocumentRepository $repository
     * @param CloudinaryWrapper  $cloud
     */
    public function __construct(DocumentRepository $repository, CloudinaryWrapper $cloud)
    {
        $this->repository = $repository;
        $this->cloud = $cloud;
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
            $this->cloud
        );

        $this->repository->save($document);
    }
}