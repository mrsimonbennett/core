<?php namespace FullRent\Core\Images\Events;

use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\EventSourcing\Event;
use FullRent\Core\Images\ValueObjects\ImageId;
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

    /** @var DateTime */
    private $uploadedAt;

    /**
     * @param ImageId $imageId
     * @param DateTime $uploadedAt
     */
    public function __construct(ImageId $imageId, DateTime $uploadedAt)
    {
        $this->imageId = $imageId;
        $this->uploadedAt = $uploadedAt;
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
        return new static(
            new ImageId($data['image_id']),
            DateTime::deserialize($data['uploaded_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'image_id' => (string) $this->imageId,
            'uploaded_at' => $this->uploadedAt->serialize(),
        ];
    }
}