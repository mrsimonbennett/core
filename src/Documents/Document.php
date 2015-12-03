<?php namespace FullRent\Core\Documents;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;
use Illuminate\Contracts\Filesystem\Filesystem;
use FullRent\Core\Documents\Events\DocumentStored;
use FullRent\Core\Documents\ValueObjects\DocumentName;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Documents\Events\DocumentNameChanged;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use FullRent\Core\Documents\Events\DocumentExpiryDateChanged;

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
     * @param DocumentId   $documentId
     * @param UploadedFile $file
     * @param DateTime     $expiryDate
     * @param Filesystem   $storage
     * @return static
     */
    public static function upload(
        DocumentId $documentId,
        UploadedFile $file,
        DateTime $expiryDate,
        Filesystem $storage
    ) {
        $document = new static;
        $document->documentId = $documentId;

        try {
            $storage->put((string) $documentId, file_get_contents($file));
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
     * @param DocumentName $newName
     */
    public function changeName(DocumentName $newName)
    {
        if ((string) $newName != (string) $this->documentName) {
            $this->apply(new DocumentNameChanged($this->documentId, $newName));
        }
    }

    /**
     * @param DateTime $newExpiryDate
     */
    public function changeExpiryDate(DateTime $newExpiryDate)
    {
        if ($newExpiryDate->format('d/m/Y H:i') !== $this->expiresAt->format('d/m/Y H:i')) {
            $this->apply(new DocumentExpiryDateChanged($this->documentId, $newExpiryDate));
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
     * @param DocumentNameChanged $e
     */
    protected function applyDocumentNameChanged(DocumentNameChanged $e)
    {
        $this->documentName = $e->newName();
    }

    /**
     * @param DocumentExpiryDateChanged $e
     */
    protected function applyDocumentExpiryDateChanged(DocumentExpiryDateChanged $e)
    {
        $this->expiresAt = $e->newExpiryDate();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'document-' . (string) $this->documentId;
    }
}