<?php
namespace Tests\Domain\Tenancy\ValueObjects;

use FullRent\Core\Tenancy\ValueObjects\TenancyDuration;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class TenancyDurationTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyDurationTest extends \TestCase
{
    public function testCreatingTenancyDuration()
    {
        $start = new DateTime();
        $end = new DateTime();
        $tenacyDuration = new TenancyDuration($start, $end);


        $this->assertEquals($start, $tenacyDuration->getStart());
        $this->assertEquals($end, $tenacyDuration->getEnd());
    }

    public function testCreatingTenancyDurationWithDatesWrong()
    {
        $start = new DateTime();
        $end = (new DateTime())->subDay();

        $this->setExpectedException(\InvalidArgumentException::class);
        new TenancyDuration($start, $end);
    }
    public function testSerlializer()
    {
        $start = new DateTime();
        $end = (new DateTime())->addYear();

        $tenancyDuration = new TenancyDuration($start, $end);

        $this->assertEquals($tenancyDuration,TenancyDuration::deserialize($tenancyDuration->serialize()));
    }
}