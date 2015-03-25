<?php
namespace FullRent\Core\Property;

use Broadway\Domain\AggregateRoot;

/**
 * Interface PropertyRepository
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
interface PropertyRepository
{
    /**
     * @param $id
     * @return Property
     */
    public function load($id);

    /**
     * @param AggregateRoot $aggregateRoot
     * @return void
     */
    public function save(AggregateRoot $aggregateRoot);
}