<?php namespace FullRent\Core\Images\Events;

use FullRent\Core\Images\ValueObjects\ImageId;
use SmoothPhp\Contracts\EventSourcing\Event;
use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class UploadedImageStored
 * @package FullRent\Core\Images\Events
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UploadedImageStored implements Serializable, Event
{
    /** @var ImageId */
    private $imageId;

    /**
     * @param ImageId $imageId
     */
    public function __construct(ImageId $imageId)
    {
        $this->imageId = $imageId;
    }

    /**
     * @return ImageId
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ImageId($data['image_id']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['image_id' => (string) $this->imageId];
    }
}