<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\ContractRepository;

/**
 * Class DraftContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftContractHandler implements CommandHandler
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

    public function handle(DraftContract $command)
    {
        $contract = Contract::draftContract($command->getContractId(),
                                            $command->getLandlord(),
                                            $command->getContractMinimalPeriod(),
                                            $command->getProperty(),
                                            $command->getRent(),
                                            $command->getDeposit());
        $this->contractRepository->save($contract);
    }
}