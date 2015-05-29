<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\DocumentId;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class TenantUploadedEarningsDocument
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantUploadedEarningsDocument implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var TenantId
     */
    private $tenantId;
    /**
     * @var DocumentId
     */
    private $documentId;
    /**
     * @var DateTime
     */
    private $uploadedAt;

    /**
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param DocumentId $documentId
     * @param DateTime $uploadedAt
     */
    public function __construct(
        ContractId $contractId,
        TenantId $tenantId,
        DocumentId $documentId,
        DateTime $uploadedAt
    ) {
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->documentId = $documentId;
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return DocumentId
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @return DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']),
                          new TenantId($data['tenant_id']),
                          new DocumentId($data['document_id']),
                          DateTime::deserialize($data['uploaded_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id'  => (string)$this->contractId,
            'tenant_id'   => (string)$this->tenantId,
            'document_id' => (string)$this->documentId,
            'uploaded_at' => $this->uploadedAt->serialize()
        ];
    }
}