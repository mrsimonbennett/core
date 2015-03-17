<?php

/**
 * Class RentDueDayTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentDueDayTest extends TestCase
{
    public function testCreatingRentDueDay()
    {
        $rentDue = new \FullRent\Core\Contract\ValueObjects\RentDueDay(10);

        $this->assertEquals(10, $rentDue->getRentDueDay());
    }

    /**
     *
     */
    public function testStringRentDay()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new \FullRent\Core\Contract\ValueObjects\RentDueDay("10");
    }

    /**
     *
     */
    public function testToLardRentDay()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new \FullRent\Core\Contract\ValueObjects\RentDueDay(30);
    }

    /**
     *
     */
    public function testToSmallRentDay()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new \FullRent\Core\Contract\ValueObjects\RentDueDay(0);
    }
}