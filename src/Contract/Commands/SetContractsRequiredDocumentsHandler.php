<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ContractRepository;
use FullRent\Core\Contract\Document;
use FullRent\Core\Contract\ValueObjects\ContractId;

/**
 * Class SetContractsRequiredDocumentsHandler
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractsRequiredDocumentsHandler
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

    public function handle(SetContractsRequiredDocuments $command)
    {
        $contract = $this->contractRepository->load(new ContractId($command->getContractId()));

        $documents = [];

        if ($command->isRequireId()) {
            $documents[] = new Document('require_id', 'fr');
        }
        if ($command->isRequireProofOfEarnings()) {
            $documents[] = new Document('require_earnings_proof', 'fr');
        }
        foreach ($command->getExtraDocuments() as $document) {
            $documents[] = new Document($document);
        }

        $contract->setRequiredDocuments($documents);

        $this->contractRepository->save($contract);
    }
}