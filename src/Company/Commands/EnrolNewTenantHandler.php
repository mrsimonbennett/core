<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\TenancyId;
use FullRent\Core\Company\ValueObjects\TenantEmail;
use FullRent\Core\Company\ValueObjects\TenantId;

/**
 * Class EnrolNewTenantHandler
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EnrolNewTenantHandler
{
    /** @var CompanyRepository */
    private $companyRepository;

    /**
     * EnrolNewTenantHandler constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param EnrolNewTenant $command
     */
    public function handle(EnrolNewTenant $command)
    {
        $company = $this->companyRepository->load(new CompanyId($command->getCompanyId()));

        $company->enrolNewTenant(new TenantId($command->getTenantId()),
                                 new TenancyId($command->getTenancyId()),
                                 new TenantEmail($command->getTenantEmail()));

        $this->companyRepository->save($company);
    }
}