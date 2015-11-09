<?php
namespace FullRent\Core\Contract\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class TenantJoinedContract
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantJoinedContract implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
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
     * @var DateTime
     */
    private $jointedAt;

    /**
     * @param ContractId $contractId
     * @param TenantId $tenant
     * @param DateTime $jointedAt
     */
    public function __construct(ContractId $contractId, TenantId $tenant,DateTime $jointedAt)
    {
        $this->contractId = $contractId;
        $this->tenantId = $tenant;
        $this->jointedAt = $jointedAt;
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
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']), new TenantId($data['tenant_id']),DateTime::deserialize($data['jointed_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['contract_id' => (string)$this->contractId, 'tenant_id' => (string)$this->tenantId,'jointed_at' => $this->jointedAt->serialize()];
    }
}