<?php
namespace FullRent\Core\Property\Read;

use FullRent\Core\Property\Exceptions\PropertyNotFound;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use stdClass;

/**
 * interface PropertiesReadRepository
 * @package FullRent\Core\Property\Read
 * @author Simon Bennett <simon@bennett.im>
 * @deprecated Convert to Query Bus Please
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
     * @throws PropertyNotFound
     * @return stdClass
     */
    public function getById(PropertyId $propertyId);

    /**
     * @param PropertyId $propertyId
     * @return stdClass
     */
    public function getPropertyHistory(PropertyId $propertyId);
}