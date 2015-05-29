<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;

/**
 * Class LandlordSignContractHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class LandlordSignContractHandler
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
    public function handle(LandlordSignContract $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $contract->landlordSign($command->getSignature());

        $this->contractRepository->save($contract);
    }
}