<?php namespace FullRent\Core\Images\Commands;

use FullRent\Core\Images\Image;
use FullRent\Core\Images\ImageRepository;
use Samcrosoft\Cloudinary\Wrapper\CloudinaryWrapper;

/**
 * Class StoreUploadedImageHandler
 * @package FullRent\Core\Images\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class StoreUploadedImageHandler
{
    /** @var ImageRepository */
    private $imageRepository;

    /** @var CloudinaryWrapper */
    private $cloud;

    /**
     * @param ImageRepository $imageRepository
     * @param CloudinaryWrapper $cloud
     */
    public function __construct(ImageRepository $imageRepository, CloudinaryWrapper $cloud)
    {
        $this->imageRepository = $imageRepository;
        $this->cloud = $cloud;
    }

    /**
     * @param StoreUploadedImage $command
     */
    public function handle(StoreUploadedImage $command)
    {
        $image = Image::storeUploadedImage($command->getImageId(), $command->getImage(), $this->cloud);

        $this->imageRepository->save($image);
    }
}