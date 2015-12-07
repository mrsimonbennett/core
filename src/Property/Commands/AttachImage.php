<?php namespace FullRent\Core\Property\Commands;

use SmoothPhp\CommandBus\BaseCommand;
use FullRent\Core\Property\ValueObjects\ImageId;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class AttachImage
 * @package FullRent\Core\Property\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class AttachImage extends BaseCommand
{
    /** @var PropertyId */
    private $propertyId;

    /** @var ImageId */
    private $imageId;

    /**
     * @param string $propertyId
     * @param string $imageId
     */
    public function __construct($propertyId, $imageId)
    {
        $this->propertyId = new PropertyId($propertyId);
        $this->imageId = new ImageId($imageId);
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
}