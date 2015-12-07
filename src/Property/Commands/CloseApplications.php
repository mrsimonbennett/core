<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class CloseApplications
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CloseApplications extends BaseCommand
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