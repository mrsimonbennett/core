<?php namespace FullRent\Core\Property\Events;

use FullRent\Core\ValueObjects\DateTime;
use FullRent\Core\Property\ValueObjects\ImageId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class ImageAttachedToProperty
 * @package FullRent\Core\Property\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ImageAttachedToProperty implements Serializable
{
    /** @var PropertyId */
    private $propertyId;

    /** @var ImageId */
    private $imageId;

    /** @var DateTime */
    private $attachedAt;

    /**
     * @param PropertyId $propertyId
     * @param ImageId $imageId
     * @param DateTime $attachedAt
     */
    public function __construct(PropertyId $propertyId, ImageId $imageId, DateTime $attachedAt)
    {
        $this->propertyId = $propertyId;
        $this->imageId = $imageId;
        $this->attachedAt = $attachedAt;
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
    public function wasAttachedAt()
    {
        return $this->attachedAt;
    }

    /**
     * @param array $data The serialized data
     * @return self The object instance
     */
    public static function deserialize(array $data)
    {
        return new self(
            new PropertyId($data['property_id']),
            new ImageId($data['image_id']),
            DateTime::deserialize($data['attached_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => (string) $this->propertyId,
            'image_id'    => (string) $this->imageId,
            'attached_at' => $this->attachedAt->serialize(),
        ];
    }
}