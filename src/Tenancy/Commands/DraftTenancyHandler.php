<?php
namespace FullRent\Core\Tenancy\Commands;

use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\Tenancy;
use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\RentFrequency;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DraftTenancyHandler
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftTenancyHandler
{
    /** @var TenancyRepository */
    private $tenancyRepository;

    /**
     * DraftTenancyHandler constructor.
     * @param TenancyRepository $tenancyRepository
     */
    public function __construct(TenancyRepository $tenancyRepository)
    {
        $this->tenancyRepository = $tenancyRepository;
    }

    public function handle(DraftTenancy $command)
    {
        $tenancyDuration = new TenancyDuration(DateTime::createFromFormat('d/m/y', $command->getStart()),
                                               DateTime::createFromFormat('d/m/y', $command->getEnd()));


        $tenancy = Tenancy::draft(new TenancyId($command->getTenancyId()),
                                  new PropertyId($command->getPropertyId()),
                                  $tenancyDuration,
                                  new RentDetails(RentAmount::fromPounds($command->getRentAmount()),
                                                  new RentFrequency($command->getRentFrequency())));

        $this->tenancyRepository->save($tenancy);
    }
}