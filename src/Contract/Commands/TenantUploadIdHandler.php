<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\DocumentId;
use FullRent\Core\Contract\ValueObjects\TenantId;

/**
 * Class TenantUploadDocumentsHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantUploadIdHandler
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
    public function handle(TenantUploadId $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));
        $tenant = new TenantId($command->getTenantId());

        $fileId = uuid();

        $contract->uploadIdForTenant($tenant,new DocumentId($fileId));

        $this->contractRepository->save($contract);
    }
}