<?php namespace FullRent\Core\Images;

use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Interface ImageRepository
 * @package FullRent\Core\Images
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
interface ImageRepository
{
    /**
     * @param $id
     * @return Image
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}