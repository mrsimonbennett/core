<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;

/**
 * Class LockContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class LockContractHandler
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

    public function handle(LockContract $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $contract->lock();

        $this->contractRepository->save($contract);
    }
}