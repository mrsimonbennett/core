<?php namespace FullRent\Core\Images;

use SmoothPhp\EventSourcing\AggregateRoot;
use FullRent\Core\Images\ValueObjects\ImageId;
use FullRent\Core\Images\Events\UploadedImageStored;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Image
 * @package FullRent\Core\Images
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Image extends AggregateRoot
{
    /** @var ImageId */
    private $imageId;

    /**
     * @param ImageId $imageId
     * @param UploadedFile $uploadedImage
     * @return static
     */
    public static function storeUploadedImage(ImageId $imageId, UploadedFile $uploadedImage)
    {
        $image = new static;
        $image->imageId = $imageId;
        $image->apply(new UploadedImageStored($imageId));

        return $image;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'image-' . (string) $this->imageId;
    }
}