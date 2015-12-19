<?php namespace FullRent\Core\Documents;

use League\Flysystem\Config;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Contracts\Filesystem\Filesystem;
use FullRent\Core\Documents\Events\DocumentStored;
use FullRent\Core\Documents\Storage\DocumentStore;
use FullRent\Core\Documents\ValueObjects\DocumentId;
use FullRent\Core\Documents\ValueObjects\DocumentName;
use FullRent\Core\Documents\ValueObjects\DocumentType;
use FullRent\Core\Documents\Events\DocumentNameChanged;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use FullRent\Core\Documents\Events\DocumentMovedToTrash;
use FullRent\Core\Documents\Events\DocumentTypeAttached;
use FullRent\Core\Documents\Exception\DocumentTypeImmutable;
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

    /** @var DocumentType*/
    private $documentType;

    /**
     * @param DocumentId        $documentId
     * @param UploadedFile      $file
     * @param DateTime          $expiryDate
     * @param DocumentStore        $storage
     * @return static
     */
    public static function upload(
        DocumentId $documentId,
        UploadedFile $file,
        DateTime $expiryDate,
        DocumentStore $storage
    ) {
        $document = new static;
        $document->documentId = $documentId;

        try {
            $storage->write((string) $documentId . '.' . $file->getClientOriginalExtension(), file_get_contents($file), new Config);

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
            $this->apply(new DocumentNameChanged($this->documentId, $newName, DateTime::now()));
        }
    }

    /**
     * @param DateTime $newExpiryDate
     */
    public function changeExpiryDate(DateTime $newExpiryDate)
    {
        if ($newExpiryDate->format('d/m/Y') != $this->expiresAt->format('d/m/Y')) {
            $this->apply(new DocumentExpiryDateChanged($this->documentId, $newExpiryDate, DateTime::now()));
        }
    }

    /**
     * @param DocumentType $type
     * @throws DocumentTypeImmutable
     */
    public function addType(DocumentType $type)
    {
        if (!$this->documentType || strlen(trim($this->documentType)) == 0) {
            $this->apply(new DocumentTypeAttached($this->documentId, $type, DateTime::now()));
        }

        if (!(string) $this->documentType == (string) $type) {
            throw new DocumentTypeImmutable('Document type cannot be changed once set');
        }
    }

    /**
     * Trashes a document
     */
    public function moveToTrash()
    {
        $this->apply(new DocumentMovedToTrash($this->documentId, DateTime::now()));
    }

    /**
     * @param DocumentStored $e
     */
    protected function applyDocumentStored(DocumentStored $e)
    {

        $this->documentId   = $e->getDocumentId();
        $this->documentName = $e->getDocumentName();
        $this->uploadedAt   = $e->getUploadedAt();
        $this->expiresAt    = $e->getExpiresAt();
    }

    /**
     * @param DocumentNameChanged $e
     */
    protected function applyDocumentNameChanged(DocumentNameChanged $e)
    {
        $this->documentId   = $e->documentId();
        $this->documentName = $e->newName();
    }

    /**
     * @param DocumentExpiryDateChanged $e
     */
    protected function applyDocumentExpiryDateChanged(DocumentExpiryDateChanged $e)
    {
        $this->documentId = $e->documentId();
        $this->expiresAt  = $e->newExpiryDate();
    }

    /**
     * @param DocumentTypeAttached $e
     */
    protected function applyDocumentTypeAttached(DocumentTypeAttached $e)
    {
        $this->documentId   = $e->documentId();
        $this->documentType = $e->documentType();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'document-' . (string) $this->documentId;
    }
}