<?php
namespace FullRent\Core\Company\Projection;

use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use stdClass;

/**
 * Interface CompanyReadRepository
 * @package FullRent\Core\Company\Projection
 * @author Simon Bennett <simon@bennett.im>
 */
interface CompanyReadRepository 
{
    /**
     * @param CompanyDomain $companyDomain
     * @throws CompanyNotFoundException
     * @return stdClass
     */
    public function getByDomain(CompanyDomain $companyDomain);
}