<?php
namespace FullRent\Core\Company;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\Events\TenantEnrolled;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\Company\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class Company
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class Company extends EventSourcedAggregateRoot
{
    /**
     * @var Landlord[]
     */
    private $landlords;
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
     * @return static
     */
    public static function registerCompany(CompanyId $companyId, CompanyName $companyName, CompanyDomain $companyDomain)
    {
        $company = new static();
        $company->apply(new CompanyHasBeenRegistered($companyId, $companyName, $companyDomain, DateTime::now()));

        return $company;
    }

    /**
     * @param Landlord $landlord
     */
    public function enrolLandlord(Landlord $landlord)
    {
        $this->apply(new LandlordEnrolled($this->companyId, $landlord));
    }

    /**
     * @param TenantId $tenantId
     */
    public function enrolTenant(TenantId $tenantId )
    {
        $this->apply(new TenantEnrolled($this->companyId, $tenantId, DateTime::now()));
    }

    /**
     * @param CompanyHasBeenRegistered $companyHasBeenRegistered
     */
    protected function applyCompanyHasBeenRegistered(CompanyHasBeenRegistered $companyHasBeenRegistered)
    {
        $this->companyId = $companyHasBeenRegistered->getCompanyId();
        $this->companyName = $companyHasBeenRegistered->getCompanyName();
        $this->companyDomain = $companyHasBeenRegistered->getCompanyDomain();
    }

    /**
     * @param LandlordEnrolled $landlordEnrolled
     */
    protected function applyLandlordEnrolled(LandlordEnrolled $landlordEnrolled)
    {
        $this->landlords[(string)$landlordEnrolled->getLandlord()->getLandlordId()] = $landlordEnrolled->getLandlord();
    }
    protected function applyTenantEnrolled(TenantEnrolled $e)
    {
        $this->tenants[(string)$e->getTenantId()] = $e->getTenantId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'company-'.(string)$this->companyId;
    }
}