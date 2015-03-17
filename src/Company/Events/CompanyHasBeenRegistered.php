<?php
namespace FullRent\Core\Company\Events;

use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;

/**
 * Class CompanyHasBeenRegistered
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyHasBeenRegistered
{
    /**
     * @var CompanyId
     */
    private $companyId;
    /**
     * @var CompanyName
     */
    private $companyName;
    /**
     * @var CompanyDomain
     */
    private $companyDomain;

    /**
     * @param CompanyId $companyId
     * @param CompanyName $companyName
     * @param CompanyDomain $companyDomain
     */
    public function __construct(CompanyId $companyId, CompanyName $companyName, CompanyDomain $companyDomain)
    {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
        $this->companyDomain = $companyDomain;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
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

}