<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ApplicationId;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;

/**
 * Class DraftContractFromApplicationHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftContractFromApplicationHandler
{
    /**
     * @var ContractRepository
     */
    private $contractRepository;

    /**
     * @param ContractRepository $contractRepository
     */
    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    /**
     * @param DraftContractFromApplication $command
     */
    public function handle(DraftContractFromApplication $command)
    {
        $contract = Contract::draftFromApplication(new ContractId($command->getContractId()),
                                                   new ApplicationId($command->getApplicationId()),
                                                   new PropertyId($command->getPropertyId()),
                                                   new LandlordId($command->getLandlordId()),
                                                   new CompanyId($command->getCompanyId()));
        $this->contractRepository->save($contract);
    }
}