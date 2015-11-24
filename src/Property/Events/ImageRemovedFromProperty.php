<?php namespace FullRent\Core\Property\Events;

use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\Property\ValueObjects\ImageId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class ImageRemovedFromProperty
 * @package FullRent\Core\Property\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ImageRemovedFromProperty implements Serializable, Event
{
    /** @var PropertyId */
    private $propertyId;
    /** @var ImageId */
    private $imageId;
    /** @var DateTime */
    private $removedAt;

    /**
     * @param PropertyId $propertyId
     * @param ImageId $imageId
     * @param DateTime $removedAt
     */
    public function __construct(PropertyId $propertyId, ImageId $imageId, DateTime $removedAt)
    {
        $this->propertyId = $propertyId;
        $this->imageId = $imageId;
        $this->removedAt = $removedAt;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return ImageId
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @return DateTime
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => (string) $this->propertyId,
            'image_id'    => (string) $this->imageId,
            'removed_at'  => $this->removedAt->serialize(),
        ];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static(
            new PropertyId($data['property_id']),
            new ImageId($data['image_id']),
            DateTime::deserialize($data['removed_at'])
        );
    }
}