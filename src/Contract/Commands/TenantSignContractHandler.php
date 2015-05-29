<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\TenantId;

/**
 * Class TenantSignContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantSignContractHandler implements CommandHandler
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

    public function handle(TenantSignContract $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $contract->tenantSign(new TenantId($command->getTenantId()), $command->getSignatureDataUrl());

        $this->contractRepository->save($contract);
    }
}