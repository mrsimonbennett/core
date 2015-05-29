<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class TenantSignContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantSignContract 
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
     * @var string
     */
    private $signatureDataUrl;

    /**
     * @param string $contractId
     * @param string $tenantId
     * @param string $signatureDataUrl
     */
    public function __construct($contractId, $tenantId, $signatureDataUrl)
    {
        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->signatureDataUrl = $signatureDataUrl;
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
     * @return string
     */
    public function getSignatureDataUrl()
    {
        return $this->signatureDataUrl;
    }

}