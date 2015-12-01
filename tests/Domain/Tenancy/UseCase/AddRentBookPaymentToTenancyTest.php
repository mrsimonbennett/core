<?php
namespace Tests\Domain\Tenancy\UseCase;

use FullRent\Core\Tenancy\Commands\ScheduleTenancyRentPayment;
use FullRent\Core\Tenancy\Commands\ScheduleTenancyRentPaymentHandler;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\Events\TenancyRentPaymentScheduled;
use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\Tenancy;
use FullRent\Core\Tenancy\ValueObjects\CompanyId;
use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\RentFrequency;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class AddRentBookPaymentToTenancyTest
 * @package Tests\Domain\Tenancy\UseCase
 * @author Simon Bennett <simon@bennett.im>
 */
final class AddRentBookPaymentToTenancyTest extends \Specification
{

    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [
            new TenancyDrafted(TenancyId::fromString(uuid()),
                               new PropertyId(uuid()),
                               new CompanyId(uuid()),
                               new TenancyDuration(DateTime::now(), DateTime::now()->addYear()),
                               new RentDetails(new RentAmount(100), new RentFrequency('1-month')),
                               DateTime::now()),
        ];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new ScheduleTenancyRentPayment(uuid(),uuid(), 100, DateTime::now()->addMonth()->format('d/m/Y'));
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        return new ScheduleTenancyRentPaymentHandler($repository);
    }

    /**
     * @return string
     */
    public function subject()
    {
        return Tenancy::class;
    }

    /**
     * @return string
     */
    public function repository()
    {
        return TenancyRepository::class;
    }

    /**
     * @test
     */
    public function expect()
    {
        $this->assertCount(1, $this->getEvents());
        $this->assertInstanceOf(TenancyRentPaymentScheduled::class, $this->getEvents()[0]);
    }
}