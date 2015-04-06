<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class AcceptApplications
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AcceptApplications 
{
    /**
     * @var PropertyId
     */
    private $propertyId;

    /**
     * @param PropertyId $propertyId
     */
    public function __construct(PropertyId $propertyId)
    {
        $this->propertyId = $propertyId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

}