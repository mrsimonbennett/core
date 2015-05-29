<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class TenantSignedContract
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantSignedContract implements SerializableInterface
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
     * @var string
     */
    private $signature;
    /**
     * @var DateTime
     */
    private $uploadedAt;

    /**
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param string $signature
     * @param DateTime $uploadedAt
     */
    public function __construct(
        ContractId $contractId,
        TenantId $tenantId,
        $signature,
        DateTime $uploadedAt
    ) {

        $this->contractId = $contractId;
        $this->tenantId = $tenantId;
        $this->signature = $signature;
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
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
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
                          $data['signature'],
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
            'signature' => (string)$this->signature,
            'uploaded_at' => $this->uploadedAt->serialize()
        ];
    }

}