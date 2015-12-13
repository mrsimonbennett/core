<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;

/**
 * Class SetTenancyToCollectRentWithDirectDebitHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetTenancyToCollectRentWithDirectDebitHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;


    /**
     * SetTenancyToCollectRentWithDirectDebitHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    public function handle(SetTenancyToCollectRentWithDirectDebit $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->setCollectDirectDebitWithFullRent();

        $this->tenancyRepository->save($tenancy);
    }
}