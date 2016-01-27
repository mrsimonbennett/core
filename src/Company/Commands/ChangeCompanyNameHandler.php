<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Company\ValueObjects\CompanyName;

/**
 * Class ChangeCompanyNameHandler
 * @package FullRent\Core\CompanyModal\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeCompanyNameHandler
{
    /** @var CompanyRepository */
    private $companyRepository;

    /**
     * ChangeCompanyNameHandler constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param ChangeCompanyName $command
     */
    public function handle(ChangeCompanyName $command)
    {
        $company = $this->companyRepository->load(new CompanyId($command->getCompanyId()));

        $company->changeName(new CompanyName($command->getCompanyName()));

        $this->companyRepository->save($company);

    }
}