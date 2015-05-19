<?php
namespace FullRent\Core\Contract\Commands;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class TenantUploadId
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantUploadId
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
    private $idDocument;

    /**
     * @param string $contractId
     * @param string $tenantId
     * @param UploadedFile $id

     */
    public function __construct(
        $contractId,
        $tenantId,
        UploadedFile $id = null
    ) {

        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->idDocument = $id;

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
    public function getIdDocument()
    {
        return $this->idDocument;
    }



}