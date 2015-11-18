<?php
namespace FullRent\Core\Property\Commands;

use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class AcceptApplications
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AcceptApplications  extends BaseCommand
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
        parent::__construct();
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

}