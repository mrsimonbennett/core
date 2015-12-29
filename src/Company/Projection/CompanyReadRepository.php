<?php
namespace FullRent\Core\Company\Projection;

use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use stdClass;

/**
 * Interface CompanyReadRepository
 * @package FullRent\Core\CompanyModal\Projection
 * @author Simon Bennett <simon@bennett.im>
 * @deprecated Use Query Bus
 */
interface CompanyReadRepository
{
    /**
     * @param CompanyDomain $companyDomain
     * @return bool
     */
    public function doesDomainExist(CompanyDomain $companyDomain);
    /**
     * @param CompanyDomain $companyDomain
     * @throws CompanyNotFoundException
     * @return stdClass
     */
    public function getByDomain(CompanyDomain $companyDomain);

    /**
     * @param CompanyId $companyId
     * @throws CompanyNotFoundException
     * @return stdClass
     */
    public function getById(CompanyId $companyId);
}