<?php namespace FullRent\Core\Images\Repository;

use FullRent\Core\Images\Image;
use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothImageRepository
 * @package FullRent\Core\Images\Repository
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class SmoothImageRepository extends EventSourcedRepository implements ImageRepository
{
    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'image-';
    }

    protected function getAggregateType()
    {
        return Image::class;
    }
}