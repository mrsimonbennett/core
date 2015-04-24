<?php
namespace FullRent\Core\Contract\Query;

use FullRent\Core\Contract\ValueObjects\PropertyId;

/**
 * Interface ContractReadRepository
 * @package FullRent\Core\Contract\Query
 * @author Simon Bennett <simon@bennett.im>
 */
interface ContractReadRepository
{
    /**
     * @param PropertyId $propertyId
     * @return \stdClass
     */
    public function getByProperty(PropertyId $propertyId);
}