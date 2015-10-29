<?php namespace FullRent\Core\Property\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Property\ValueObjects\ImageId;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class ImageAttachedToProperty
 * @package FullRent\Core\Property\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ImageAttachedToProperty implements SerializableInterface
{
    /** @var PropertyId */
    private $propertyId;

    /** @var ImageId */
    private $imageId;

    /**
     * @param PropertyId $propertyId
     * @param ImageId $imageId
     */
    public function __construct(PropertyId $propertyId, ImageId $imageId)
    {
        $this->propertyId = $propertyId;
        $this->imageId = $imageId;
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
     * @param array $data The serialized data
     * @return self The object instance
     */
    public static function deserialize(array $data)
    {
        return new self(new PropertyId($data['property_id']), new ImageId($data['image_id']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id' => (string) $this->propertyId,
            'image_id'    => (string) $this->imageId,
        ];
    }
}