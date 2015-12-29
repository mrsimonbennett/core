<?php
namespace FullRent\Core\Company\Commands;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;

/**
 * Class RegisterDirectDebitServiceHandler
 * @package FullRent\Core\CompanyModal\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterDirectDebitServiceHandler
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var DirectDebitAccountAuthorisation
     */
    private $accountAuthorisation;

    /**
     * @param CompanyRepository $companyRepository
     */
    public function __construct(
        CompanyRepository $companyRepository,
        DirectDebitAccountAuthorisation $accountAuthorisation
    ) {
        $this->companyRepository = $companyRepository;
        $this->accountAuthorisation = $accountAuthorisation;
    }

    /**
     * @param RegisterDirectDebitService $command
     */
    public function handle(RegisterDirectDebitService $command)
    {
        $company = $this->companyRepository->load(new CompanyId($command->getCompanyId()));

        $company->authorizeDirectDebit($command->getDirectDebitAuthCode(),
                                       $command->getRedirectPath(),
                                       $this->accountAuthorisation);

        $this->companyRepository->save($company);
    }
}