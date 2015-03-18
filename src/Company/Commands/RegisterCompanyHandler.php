<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Company\Company;
use FullRent\Core\Company\CompanyRepository;

/**
 * Class RegisterCompanyHandler
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterCompanyHandler implements CommandHandler
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
     * @param RegisterCompany $command
     * @return void
     */
    public function handle(RegisterCompany $command)
    {
        $company = Company::registerCompany(
            $command->getCompanyId(),
            $command->getCompanyName(),
            $command->getCompanyDomain()
        );

        $this->companyRepository->save($company);
    }
}