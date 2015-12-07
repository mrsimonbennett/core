<?php namespace FullRent\Core\Images;

use Exception;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;
use FullRent\Core\Images\ValueObjects\ImageId;
use FullRent\Core\Images\Events\UploadedImageStored;
use Samcrosoft\Cloudinary\Wrapper\CloudinaryWrapper;
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
     * @param CloudinaryWrapper $cloud
     * @return static
     */
    public static function storeUploadedImage(ImageId $imageId, UploadedFile $uploadedImage, CloudinaryWrapper $cloud)
    {
        $image = new static;
        $image->imageId = $imageId;
        try {
            $cloud->upload($uploadedImage->getRealPath(), (string) $imageId);
            $image->apply(new UploadedImageStored($imageId, new DateTime));

            return $image;
        } catch (Exception $e) {
            \Log::debug("Uploading Image {$image->imageId} failed:\n{$e->getMessage()}\n\n");
        }
    }

    /**
     * @param UploadedImageStored $event
     */
    protected function applyUploadedImageStored(UploadedImageStored $event)
    {
        $this->imageId = $event->getImageId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'image-' . (string) $this->imageId;
    }
}