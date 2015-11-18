<?php namespace FullRent\Core\Images\Commands;

use FullRent\Core\Images\Image;
use FullRent\Core\Images\ImageRepository;

/**
 * Class StoreUploadedImageHandler
 * @package FullRent\Core\Images\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class StoreUploadedImageHandler
{
    /** @var ImageRepository */
    private $imageRepository;

    /**
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param StoreUploadedImage $command
     */
    public function handle(StoreUploadedImage $command)
    {
        $image = Image::storeUploadedImage($command->getImageId(), $command->getImage());

        $this->imageRepository->save($image);
    }
}