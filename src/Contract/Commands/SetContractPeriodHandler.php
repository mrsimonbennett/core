<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class SetContractPeriodHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractPeriodHandler implements CommandHandler
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
     * @param SetContractPeriod $command
     */
    public function handle(SetContractPeriod $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $contract->setContractPeriod(DateTime::createFromFormat('d/m/Y',$command->getStart()),DateTime::createFromFormat('d/m/Y',$command->getEnd()));

        $this->contractRepository->save($contract);
    }
}