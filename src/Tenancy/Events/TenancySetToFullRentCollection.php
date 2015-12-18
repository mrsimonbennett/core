<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class TenancySetToFullRentCollection
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancySetToFullRentCollection implements Serializable, Event
{
    /** @var TenancyId */
    private $tenancyId;

    /** @var DateTime */
    private $setAt;

    /**
     * TenancySetToFullRentCollection constructor.
     * @param TenancyId $tenancyId
     * @param DateTime $setAt
     */
    public function __construct(TenancyId $tenancyId, DateTime $setAt)
    {
        $this->tenancyId = $tenancyId;
        $this->setAt = $setAt;
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return DateTime
     */
    public function getSetAt()
    {
        return $this->setAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['tenancy_id' => (string)$this->tenancyId, 'set_at' => $this->setAt->serialize()];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new TenancyId($data['tenancy_id']), DateTime::deserialize($data['set_at']));
    }
}