<?php
namespace FullRent\Core\Property\Read;

use FullRent\Core\Property\Exceptions\PropertyNotFoundException;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use stdClass;

/**
 * interface PropertiesReadRepository
 * @package FullRent\Core\Property\Read
 * @author Simon Bennett <simon@bennett.im>
 */
interface PropertiesReadRepository
{
    /**
     * @param CompanyId $companyId
     * @return mixed
     */
   public function getByCompany(CompanyId $companyId);

    /**
     * @param PropertyId $propertyId
     * @throws PropertyNotFoundException
     * @return stdClass
     */
    public function getById(PropertyId $propertyId);

    /**
     * @param PropertyId $propertyId
     * @return stdClass
     */
    public function getPropertyHistory(PropertyId $propertyId);
}