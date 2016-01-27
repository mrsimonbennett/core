<?php
namespace FullRent\Core\Property;

use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothPropertyRepository
 * @package FullRent\Core\Property
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothPropertyRepository extends EventSourcedRepository implements PropertyRepository
{

    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'property-';
    }

    /**
     * @return mixed
     */
    protected function getAggregateType()
    {
        return Property::class;
    }
}