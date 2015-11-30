<?php namespace FullRent\Core\Documents;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;
use FullRent\Core\Documents\Events\DocumentStored;
use FullRent\Core\Images\ValueObjects\DocumentName;
use Samcrosoft\Cloudinary\Wrapper\CloudinaryWrapper;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Document
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Document extends AggregateRoot
{
    /** @var DocumentId */
    private $documentId;

    /** @var DocumentName */
    private $documentName;

    /** @var DateTime */
    private $uploadedAt;

    /** @var DateTime */
    private $expiresAt;

    /**
     * @param DocumentId        $documentId
     * @param UploadedFile      $file
     * @param DateTime          $expiryDate
     * @param CloudinaryWrapper $cloud
     * @return static
     */
    public static function upload(
        DocumentId $documentId,
        UploadedFile $file,
        DateTime $expiryDate,
        CloudinaryWrapper $cloud
    ) {
        $document = new static;
        $document->documentId = $documentId;

        try {
            $cloud->upload((string) $documentId, $file->getRealPath());
            $document->apply(new DocumentStored(
                $documentId,
                new DocumentName($file->getClientOriginalName()),
                $expiryDate,
                DateTime::now()
            ));

            return $document;
        } catch (\Exception $e) {
            \Log::error(sprintf("Document [%s] failed to upload: \n%s\n\n", $documentId, $e->getMessage()));
        }
    }

    /**
     * @param DocumentStored $e
     */
    protected function applyDocumentStored(DocumentStored $e)
    {
        $this->documentName = $e->getDocumentName();
        $this->uploadedAt   = $e->getUploadedAt();
        $this->expiresAt    = $e->getExpiresAt();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'document-' . (string) $this->documentId;
    }
}