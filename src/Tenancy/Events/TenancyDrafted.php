<?php
namespace FullRent\Core\Tenancy\Events;

use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class TenancyDrafted
 * @package FullRent\Core\Tenancy\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyDrafted implements Serializable, Event
{
    /** @var TenancyId */
    private $tenancyId;

    /** @var PropertyId */
    private $propertyId;

    /** @var TenancyDuration */
    private $tenancyDuration;

    /** @var RentDetails */
    private $rentDetails;

    /** @var DateTime */
    private $draftedAt;

    /**
     * TenancyDrafted constructor.
     * @param TenancyId $tenancyId
     * @param PropertyId $propertyId
     * @param TenancyDuration $tenancyDuration
     * @param RentDetails $rentDetails
     * @param DateTime $draftedAt
     */
    public function __construct(
        TenancyId $tenancyId,
        PropertyId $propertyId,
        TenancyDuration $tenancyDuration,
        RentDetails $rentDetails,
        DateTime $draftedAt
    ) {
        $this->tenancyId = $tenancyId;
        $this->propertyId = $propertyId;
        $this->tenancyDuration = $tenancyDuration;
        $this->rentDetails = $rentDetails;
        $this->draftedAt = $draftedAt;
    }

    /**
     * @return TenancyId
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return TenancyDuration
     */
    public function getTenancyDuration()
    {
        return $this->tenancyDuration;
    }

    /**
     * @return RentDetails
     */
    public function getRentDetails()
    {
        return $this->rentDetails;
    }

    /**
     * @return DateTime
     */
    public function getDraftedAt()
    {
        return $this->draftedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tenancy_id'   => (string)$this->tenancyId,
            'property_id'  => (string)$this->propertyId,
            'duration'     => $this->tenancyDuration->serialize(),
            'rent_details' => $this->rentDetails->serialize(),
            'drafted_at'   => $this->draftedAt->serialize()
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(new TenancyId($data['tenancy_id']),
                          new PropertyId($data['property_id']),
                          TenancyDuration::deserialize($data['duration']),
                          RentDetails::deserialize($data['rent_details']),
                          DateTime::deserialize($data['drafted_at']));
    }
}