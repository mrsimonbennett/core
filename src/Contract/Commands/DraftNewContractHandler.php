<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\RentAmount;
use FullRent\Core\Contract\ValueObjects\RentDueDay;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DraftNewContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftNewContractHandler
{
    /** @var ContractRepository */
    private $contractRepository;

    /**
     * DraftNewContractHandler constructor.
     * @param ContractRepository $contractRepository
     */
    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }

    /**
     * @param DraftNewContract $command
     */
    public function handle(DraftNewContract $command)
    {
        $contract = Contract::draftContract(new ContractId($command->getContractId()),
                                            new PropertyId($command->getPropertyId()),
                                            new CompanyId($command->getCompanyId()),
                                            new LandlordId($command->getLandlordId()),
                                            new Rent(RentAmount::fromPounds($command->getRent()),
                                                     new RentDueDay((int)$command->getRentPayable()),
                                                     DateTime::createFromFormat('d/y/Y', $command->getFirstPaymentDue()),
                                                     DateTime::createFromFormat('d/y/Y', $command->getStart()),
                                                     DateTime::createFromFormat('d/y/Y', $command->getEnd()),
                                                (bool) $command->getFullrentRentCollection()));

        $this->contractRepository->save($contract);
    }
}