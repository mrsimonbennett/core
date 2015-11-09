<?php
namespace FullRent\Core\Property\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class PropertyClosedAcceptingApplications
 * @package FullRent\Core\Property\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyClosedAcceptingApplications implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var DateTime
     */
    private $changedAt;

    /**
     * @param PropertyId $propertyId
     * @param DateTime $changedAt
     */
    public function __construct(PropertyId $propertyId, DateTime $changedAt)
    {
        $this->propertyId = $propertyId;
        $this->changedAt = $changedAt;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return DateTime
     */
    public function getChangedAt()
    {
        return $this->changedAt;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new PropertyId($data['property_id']), DateTime::deserialize($data['changed_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['property_id' => (string)$this->propertyId, 'changed_at' => $this->changedAt->serialize()];
    }
}