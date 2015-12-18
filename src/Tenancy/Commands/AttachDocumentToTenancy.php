<?php namespace FullRent\Core\Tenancy\Commands;

use SmoothPhp\CommandBus\BaseCommand;
use FullRent\Core\Tenancy\ValueObjects\DocumentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;

/**
 * Class AttachDocumentToTenancy
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class AttachDocumentToTenancy extends BaseCommand
{
    /** @var TenancyId */
    private $tenancyId;

    /** @var DocumentId */
    private $documentId;

    /**
     * @param string $tenancyId
     * @param string $documentId
     */
    public function __construct($tenancyId, $documentId)
    {
        $this->tenancyId = new TenancyId($tenancyId);
        $this->documentId = new DocumentId($documentId);
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return DocumentId
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }
}