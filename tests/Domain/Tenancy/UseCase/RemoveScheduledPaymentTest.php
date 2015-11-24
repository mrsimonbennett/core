<?php
namespace Tests\Domain\Tenancy\UseCase;

use Command;
use FullRent\Core\Tenancy\Commands\RemoveScheduledRentPayment;
use FullRent\Core\Tenancy\Commands\RemoveScheduledRentPaymentHandler;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\Events\TenancyRentPaymentScheduled;
use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\Tenancy;
use FullRent\Core\Tenancy\ValueObjects\CompanyId;
use FullRent\Core\Tenancy\ValueObjects\PropertyId;
use FullRent\Core\Tenancy\ValueObjects\RentAmount;
use FullRent\Core\Tenancy\ValueObjects\RentDetails;
use FullRent\Core\Tenancy\ValueObjects\RentFrequency;
use FullRent\Core\Tenancy\ValueObjects\RentPaymentId;
use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\Tenancy\ValueObjects\TenancyId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ChangeScheduledPaymentTest
 * @package Tests\Domain\Tenancy\UseCase
 * @author Simon Bennett <simon@bennett.im>
 */
final class RemoveScheduledPaymentTest extends \Specification
{
    /**
     * @var string
     */
    private $tenancyId;

    /**
     * @var string
     */
    private $paymentId;

    public function setup()
    {
        $this->tenancyId = uuid();
        $this->paymentId = uuid();

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
            new TenancyRentPaymentScheduled(TenancyId::fromString($this->tenancyId),
                                            RentPaymentId::fromString($this->paymentId),
                                            new RentAmount(12),
                                            new DateTime(),
                                            new DateTime()),
        ];
    }

    /**
     * @return BaseCommand
     */
    public function when()
    {
        return new RemoveScheduledRentPayment($this->tenancyId, $this->paymentId);
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        return new RemoveScheduledRentPaymentHandler($repository);
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
    }
}