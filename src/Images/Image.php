<?php namespace FullRent\Core\Images;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Images\ValueObjects\ImageId;

/**
 * Class Image
 * @package FullRent\Core\Images
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class Image extends EventSourcedAggregateRoot
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