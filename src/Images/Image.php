<?php namespace FullRent\Core\Images;

use SmoothPhp\EventSourcing\AggregateRoot;
use FullRent\Core\Images\ValueObjects\ImageId;

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
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'image-' . (string) $this->imageId;
    }
}