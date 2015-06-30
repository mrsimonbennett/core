<?php
namespace FullRent\Core\Property\Queries;

/**
 * Class FindPropertyById
 * @package FullRent\Core\Property\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertyById
{
    private $propertyId;

    /**
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