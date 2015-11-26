<?php
namespace FullRent\Core\Tenancy\Queries;

/**
 * Class FindPropertiesDraftTenancies
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertiesDraftTenancies
{
    private $propertyId;

    /**
     * FindPropertiesDraftTenancies constructor.
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