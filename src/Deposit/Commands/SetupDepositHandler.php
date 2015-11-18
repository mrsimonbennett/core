<?php
namespace FullRent\Core\Deposit\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Deposit\Deposit;
use FullRent\Core\Deposit\Repository\DepositRepository;
use FullRent\Core\Deposit\ValueObjects\ContractId;
use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Deposit\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class SetupDepositHandler
 * @package FullRent\Core\Deposit\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetupDepositHandler
{
    /**
     * @var DepositRepository
     */
    private $depositRepository;

    /**
     * @param DepositRepository $depositRepository
     */
    public function __construct(DepositRepository $depositRepository)
    {
        $this->depositRepository = $depositRepository;
    }

    /**
     * @param SetupDeposit $command
     */
    public function handle(SetupDeposit $command)
    {
        $deposit = Deposit::setup(new DepositId($command->getDepositId()),
                                  new ContractId($command->getContractId()),
                                  new TenantId($command->getTenantId()),
                                  DepositAmount::fromPounds($command->getDepositAmountPounds()),
                                  new DateTime($command->getDepositDue()),
                                  $command->isFullrentDepositCollection());
        $this->depositRepository->save($deposit);
    }
}