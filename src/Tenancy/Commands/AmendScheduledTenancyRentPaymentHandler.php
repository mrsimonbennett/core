<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class AmendScheduledTenancyRentPaymentHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AmendScheduledTenancyRentPaymentHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * AmendScheduledTenancyRentPaymentHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    public function handle(AmendScheduledTenancyRentPayment $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->amendScheduledPayment(new RentPaymentId($command->getPaymentId()),
                                        RentAmount::fromPounds($command->getNewRentAmount()),
                                        DateTime::createFromFormat('d/m/Y', $command->getNewRentDue()));

        $this->tenancyRepository->save($tenancy);
    }
}