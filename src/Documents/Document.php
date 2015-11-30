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

    /**
     * @param DocumentId        $documentId
     * @param UploadedFile      $file
     * @param CloudinaryWrapper $cloud
     */
    public static function upload(DocumentId $documentId, UploadedFile $file, CloudinaryWrapper $cloud)
    {
        $document = new static;
        $document->documentId = $documentId;

        try {
            $cloud->upload((string) $documentId, $file->getRealPath());
            $document->apply(new DocumentStored($documentId, new DocumentName($file->getClientOriginalName()), DateTime::now()));
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
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'document-' . (string) $this->documentId;
    }
}