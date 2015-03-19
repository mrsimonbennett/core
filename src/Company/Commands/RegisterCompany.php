<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;

/**
 * Class RegisterCompany
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterCompany
{
    /**
     * @var CompanyName
     */
    private $companyName;
    /**
     * @var CompanyDomain
     */
    private $companyDomain;
    /**
     * @var CompanyId
     */
    private $companyId;

    /**
     * @param CompanyName $companyName
     * @param CompanyDomain $companyDomain
     */
    public function __construct(CompanyName $companyName, CompanyDomain $companyDomain)
    {
        $this->companyId = CompanyId::random();
        $this->companyName = $companyName;
        $this->companyDomain = $companyDomain;
    }

    /**
     * @return CompanyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return CompanyDomain
     */
    public function getCompanyDomain()
    {
        return $this->companyDomain;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

}