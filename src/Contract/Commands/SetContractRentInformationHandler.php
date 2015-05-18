<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\DepositAmount;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\RentAmount;
use FullRent\Core\Contract\ValueObjects\RentDueDay;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class SetContractRentInformationHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractRentInformationHandler
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
     * @param SetContractRentInformation $command
     */
    public function handle(SetContractRentInformation $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $rent = new Rent(RentAmount::fromPounds($command->getRent()),
                         new RentDueDay((int)$command->getRentPayable()),
                         DateTime::createFromFormat('d/m/Y', $command->getFirstRentPayment())->startOfDay(),
                         $command->isFullRentRentCollection());
        $deposit = new Deposit(DepositAmount::fromPounds($command->getDeposit()),
                               DateTime::createFromFormat('d/m/Y', $command->getDepositDue())->startOfDay(),
                               (bool)$command->getFullRentDepositCollection());

        $contract->draftRentInformation($rent, $deposit);

        $this->contractRepository->save($contract);
    }
}