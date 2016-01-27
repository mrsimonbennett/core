<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;

/**
 * Class RemoveScheduledRentPaymentHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RemoveScheduledRentPaymentHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * RemoveScheduledRentPaymentHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    /**
     * @param RemoveScheduledRentPayment $command
     */
    public function handle(RemoveScheduledRentPayment $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->removeScheduledRent(new RentPaymentId($command->getPaymentId()));

        $this->tenancyRepository->save($tenancy);
    }
}