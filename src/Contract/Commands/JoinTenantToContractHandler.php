<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\TenantId;

/**
 * Class JoinTenantToContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class JoinTenantToContractHandler
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
     * @param JoinTenantToContract $command
     * @throws \FullRent\Core\Contract\Exceptions\TenantAlreadyJoinedContractException
     */
    public function handle(JoinTenantToContract $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));
        $contract->attachTenant(new TenantId($command->getTenantId()));
        $this->contractRepository->save($contract);
    }
}