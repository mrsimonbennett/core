<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ScheduleTenancyRentPaymentHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ScheduleTenancyRentPaymentHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * ScheduleTenancyRentPaymentHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    /**
     * @param ScheduleTenancyRentPayment $command
     */
    public function handle(ScheduleTenancyRentPayment $command)
    {
        $tenancy = $this->tenancyRepository->load(new TenancyId($command->getTenancyId()));

        $tenancy->schedulePayment(new RentPaymentId($command->getRentPaymentId()),
                                  RentAmount::fromPounds($command->getRentAmount()),
                                  DateTime::createFromFormat('d/m/Y', $command->getDueOn()));


        $this->tenancyRepository->save($tenancy);
    }
}