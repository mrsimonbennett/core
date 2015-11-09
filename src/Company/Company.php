<?php
namespace FullRent\Core\Company;

use FullRent\Core\Company\Events\CompanyDomainChanged;
use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\CompanyNameChanged;
use FullRent\Core\Company\Events\CompanySetUpDirectDebit;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\Events\TenantEnrolled;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\Company\ValueObjects\TenantId;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Company
 * @package FullRent\Core\Company
 * @author Simon Bennett <simon@bennett.im>
 */
final class Company extends AggregateRoot
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
    public function enrolTenant(TenantId $tenantId)
    {
        $this->apply(new TenantEnrolled($this->companyId, $tenantId, DateTime::now()));
    }

    /**
     * @param $authCode
     * @param DirectDebitAccountAuthorisation $accountAuthorisation
     */
    public function authorizeDirectDebit($authCode, DirectDebitAccountAuthorisation $accountAuthorisation)
    {
        $accessTokens = $accountAuthorisation->getAccessToken($this->companyDomain, $authCode);
        $this->apply(new CompanySetUpDirectDebit($this->companyId,
                                                 $accessTokens->getMerchantId(),
                                                 $accessTokens->getAccessToken(),
                                                 DateTime::now()));
    }

    /**
     * @param CompanyName $companyName
     */
    public function changeName(CompanyName $companyName)
    {
        $this->apply(new CompanyNameChanged($this->companyId, $companyName, DateTime::now()));
    }

    /**
     * @param CompanyDomain $companyDomain
     */
    public function changeDomain(CompanyDomain $companyDomain)
    {
        $this->apply(new CompanyDomainChanged($this->companyId,$companyDomain,DateTime::now()));
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
        return 'company-' . (string)$this->companyId;
    }
}