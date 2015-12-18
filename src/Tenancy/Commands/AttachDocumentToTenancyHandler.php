<?php namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;

final class AttachDocumentToTenancyHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    /**
     * @param AttachDocumentToTenancy $command
     */
    public function handle(AttachDocumentToTenancy $command)
    {
        $tenancy = $this->tenancyRepository->load($command->getTenancyId());

        $tenancy->attachDocument($command->getDocumentId());

        $this->tenancyRepository->save($tenancy);
    }
}