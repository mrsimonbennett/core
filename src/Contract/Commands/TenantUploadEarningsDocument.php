<?php
namespace FullRent\Core\Contract\Commands;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class TenantUploadEarningsDocument
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantUploadEarningsDocument 
{
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $tenantId;
    /**
     * @var UploadedFile
     */
    private $earningsDocument;

    /**
     * @param string $contractId
     * @param string $tenantId
     * @param UploadedFile $earningsDocument

     */
    public function __construct(
        $contractId,
        $tenantId,
        UploadedFile $earningsDocument = null
    ) {

        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->earningsDocument = $earningsDocument;

    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return UploadedFile
     */
    public function getEarningsDocument()
    {
        return $this->earningsDocument;
    }
}