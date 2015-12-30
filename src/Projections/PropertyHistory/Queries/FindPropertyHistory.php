<?php
namespace FullRent\Core\Projections\PropertyHistory\Queries;

/**
 * Class FindPropertyHistory
 * @package FullRent\Core\Projections\PropertyHistory\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertyHistory
{
    private $propertyId;

    /**
     * FindPropertyHistory constructor.
     * @param $propertyId
     */
    public function __construct($propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return mixed
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

}