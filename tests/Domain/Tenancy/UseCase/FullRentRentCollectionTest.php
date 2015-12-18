<?php
namespace Tests\Domain\Tenancy\UseCase;

use FullRent\Core\Tenancy\Commands\SetTenancyToCollectRentWithDirectDebit;
use FullRent\Core\Tenancy\Commands\SetTenancyToCollectRentWithDirectDebitHandler;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
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
 * Class FullRentRentCollectionTest
 * @package Tests\Domain\Tenancy\UseCase
 * @author Simon Bennett <simon@bennett.im>
 */
final class FullRentRentCollectionTest extends \Specification
{
    public function setup()
    {
        $this->tenancyId = uuid();

        parent::setUp();
    }

    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [
            new TenancyDrafted(TenancyId::fromString($this->tenancyId),
                               new PropertyId(uuid()),
                               new CompanyId(uuid()),
                               new TenancyDuration(DateTime::now(), DateTime::now()->addYear()),
                               new RentDetails(new RentAmount(100), new RentFrequency('1-month')),
                               DateTime::now()),

        ];
    }

    /**
     * @return \SmoothPhp\CommandBus\BaseCommand
     */
    public function when()
    {
        return new SetTenancyToCollectRentWithDirectDebit($this->tenancyId);
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        return new SetTenancyToCollectRentWithDirectDebitHandler($repository);
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
    public function check_event()
    {
        $this->assertCount(1, $this->getEvents());

    }
}