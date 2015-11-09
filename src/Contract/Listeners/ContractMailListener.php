<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Contract\Events\ContractLocked;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\UserId;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class MailListener
 * @package FullRent\Core\Contract\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractMailListener implements Subscriber
{
    /**
     * @var EmailClient
     */
    private $emailClient;

    /**
     * @var ContractReadRepository
     */
    private $contractReadRepository;

    /**
     * @var PropertiesReadRepository
     */
    private $propertiesReadRepository;

    /**
     * @var CompanyReadRepository
     */
    private $companyReadRepository;

    /**
     * @var UserReadRepository
     */
    private $userReadRepository;

    /**
     * @param EmailClient $emailClient
     * @param ContractReadRepository $contractReadRepository
     * @param PropertiesReadRepository $propertiesReadRepository
     * @param CompanyReadRepository $companyReadRepository
     * @param UserReadRepository $userReadRepository
     */
    public function __construct(
        EmailClient $emailClient,
        ContractReadRepository $contractReadRepository,
        PropertiesReadRepository $propertiesReadRepository,
        CompanyReadRepository $companyReadRepository,
        UserReadRepository $userReadRepository
    ) {
        $this->emailClient = $emailClient;
        $this->contractReadRepository = $contractReadRepository;
        $this->propertiesReadRepository = $propertiesReadRepository;
        $this->companyReadRepository = $companyReadRepository;
        $this->userReadRepository = $userReadRepository;
    }

    /**
     * @param ContractLocked $contractLocked
     */
    public function whenContractLockedEmailTenantForPaperWork(ContractLocked $contractLocked)
    {
        $contract = $this->contractReadRepository->getById($contractLocked->getContractId());
        $property = $this->propertiesReadRepository->getById(new PropertyId($contract->property_id));
        $company = $this->companyReadRepository->getById(new CompanyId($contract->company_id));

        foreach ($contract->tenants as $tenant) {
            $this->emailClient->send('contracts.ask-tenant-to-sign',
                                     "The contract for {$property->address_firstline} is ready for you to review",
                                     [
                                         'tenant'   => $tenant,
                                         'property' => $property,
                                         'company'  => $company,
                                         'landlord' => $this->userReadRepository->getById(new UserId($property->landlord_id)),
                                         'contract' => $contract,
                                     ],
                                     $tenant->known_as,
                                     $tenant->email);
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            ContractLocked::class => ['whenContractLockedEmailTenantForPaperWork'],
        ];
    }
}