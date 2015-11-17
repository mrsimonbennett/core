<?php namespace FullRent\Core\Images\Commands;

use FullRent\Core\Images\ValueObjects\ImageId;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class StoreUploadedImage
 * @package FullRent\Core\Images\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class StoreUploadedImage
{
    /** @var ImageId */
    private $imageId;

    /** @var UploadedFile */
    private $image;

    /**
     * @param string       $imageId
     * @param UploadedFile $image
     */
    public function __construct($imageId, UploadedFile $image)
    {
        $this->imageId = new ImageId($imageId);
        $this->image = $image;
    }

    /**
     * @return ImageId
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }
}