<?php namespace FullRent\Core\Images\Repository;

use FullRent\Core\Images\Image;
use FullRent\Core\Images\ValueObjects\ImageId;
use SmoothPhp\Contracts\EventSourcing\AggregateRoot;

/**
 * Interface ImageRepository
 * @package FullRent\Core\Images
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
interface ImageRepository
{
    /**
     * @param ImageId $id
     * @return Image
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}