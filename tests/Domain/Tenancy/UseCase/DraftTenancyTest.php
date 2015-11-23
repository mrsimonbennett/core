<?php
namespace Tests\Domain\Tenancy\UseCase;

use FullRent\Core\Tenancy\Commands\DraftTenancy;
use FullRent\Core\Tenancy\Commands\DraftTenancyHandler;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\Repositories\TenancyRepository;
use FullRent\Core\Tenancy\Tenancy;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DraftTenancyTest
 * @package Tests\Domain\Tenancy\UseCase
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftTenancyTest extends \Specification
{

    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new DraftTenancy(uuid(),
                                uuid(),
                                uuid(),
                                DateTime::now()->format('d/m/Y'),
                                DateTime::now()->addYear()->format('d/m/Y'),
                                200,
                                '1-month');
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        return new DraftTenancyHandler($repository);
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
     *
     */
    public function testCommandGeneratedEvent()
    {
        $this->assertCount(1, $this->getEvents());
        $this->assertInstanceOf(TenancyDrafted::class, $this->getEvents()[0]);
    }
}