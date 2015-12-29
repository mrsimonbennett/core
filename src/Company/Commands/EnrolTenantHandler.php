<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\TenantId;

/**
 * Class EnrolTenantHandler
 * @package FullRent\Core\CompanyModal\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EnrolTenantHandler
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param EnrolTenant $command
     */
    public function handle(EnrolTenant $command)
    {
        $company = $this->companyRepository->load(new CompanyId($command->getCompanyId()));

        $company->enrolTenant(new TenantId($command->getTenantId()));

        $this->companyRepository->save($company);
    }
}