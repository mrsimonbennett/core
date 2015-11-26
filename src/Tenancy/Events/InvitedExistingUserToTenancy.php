<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\Tenancy\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class InvitedExistingUserToTenancy
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class InvitedExistingUserToTenancy implements Event, Serializable
{
    /** @var TenancyId */
    private $id;

    /** @var TenantId */
    private $tenantId;

    /** @var DateTime */
    private $invitedAt;

    /**
     * InvitedExistingUserToTenancy constructor.
     * @param TenancyId $id
     * @param TenantId $tenantId
     * @param DateTime $invitedAt
     */
    public function __construct(TenancyId $id, TenantId $tenantId, DateTime $invitedAt)
    {
        $this->id = $id;
        $this->tenantId = $tenantId;
        $this->invitedAt = $invitedAt;
    }

    /**
     * @return TenancyId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TenantId
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * @return DateTime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tenancy_id' => (string)$this->tenantId,
            'tenant_id'  => (string)$this->tenantId,
            'invited_at' => $this->invitedAt->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new TenancyId($data['tenancy_id']),
                          new TenantId($data['tenant_id']),
                          DateTime::deserialize($data['invited_at']));
    }
}