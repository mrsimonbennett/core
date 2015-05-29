<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\DocumentId;
use FullRent\Core\Contract\ValueObjects\TenantId;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class TenantUploadEarningsDocumentHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenantUploadEarningsDocumentHandler 
{
    /**
     * @var ContractRepository
     */
    private $contractRepository;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param ContractRepository $contractRepository
     * @param Filesystem $filesystem
     */
    public function __construct(ContractRepository $contractRepository, Filesystem $filesystem)
    {
        $this->contractRepository = $contractRepository;
        $this->filesystem = $filesystem;
    }
    public function handle(TenantUploadEarningsDocument $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $fileId  =  DocumentId::random();
        $contract->uploadEarningsProofForTenant(new TenantId($command->getTenantId()),$fileId);

        $this->contractRepository->save($contract);
    }
}