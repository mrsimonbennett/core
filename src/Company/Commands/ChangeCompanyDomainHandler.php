<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;

/**
 * Class ChangeCompanyDomainHandler
 * @package FullRent\Core\CompanyModal\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeCompanyDomainHandler
{
    /** @var CompanyRepository */
    private $companyRepository;

    /**
     * ChangeCompanyDomainHandler constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function handle(ChangeCompanyDomain $command)
    {
        $company = $this->companyRepository->load(new CompanyId($command->getCompanyId()));

        $company->changeDomain(new CompanyDomain($command->getCompanyDomain()));

        $this->companyRepository->save($company);
    }
}