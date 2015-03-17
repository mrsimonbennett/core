<?php
namespace FullRent\Core\Company;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;

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
        $company->apply(new CompanyHasBeenRegistered($companyId, $companyName, $companyDomain));

        return $company;
    }

    /**
     * @param Landlord $landlord
     */
    public function inRoleLandlord(Landlord $landlord)
    {
        $this->apply(new LandlordEnrolled($this->companyId, $landlord));
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

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string)$this->companyId;
    }
}