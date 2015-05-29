<?php
namespace FullRent\Core\Contract;

use FullRent\Core\Contract\Exceptions\DocumentAlreadyApproved;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\DocumentId;
use FullRent\Core\Contract\ValueObjects\TenantId;

/**
 * Class Documents
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Documents
{
    /**
     * @var TenantId
     */
    private $tenantId;
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var []
     */
    private $documents;

    /**
     * @param ContractId $contractId
     * @param TenantId $tenantId
     */
    public function __construct(ContractId $contractId, TenantId $tenantId)
    {
        $this->tenantId = $tenantId;
        $this->contractId = $contractId;
    }

    /**
     * @param DocumentId $documentId
     */
    public function uploadIdDocument(DocumentId $documentId)
    {
        $this->documents[(string)$documentId] = [
            'approved' => false,
            'type'     => 'id',
        ];
    }

    public function guardAgainstUploadingDocumentAgainOnceApproved($type)
    {
        foreach ($this->documents as $doc) {
            if ($doc['type'] == $type) {
                if ($doc['approved']) {
                    throw new DocumentAlreadyApproved();
                }
            }
        }
    }
}