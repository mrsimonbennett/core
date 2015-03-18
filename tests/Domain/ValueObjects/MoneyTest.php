<?php
namespace Domain\ValueObjects;

use FullRent\Core\ValueObjects\Money\Money;
use InvalidArgumentException;

/**
 * Class MoneyTest
 * @package Domain\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class MoneyTest extends \TestCase
{

    /**
     *
     */
    public function testMoneyToString()
    {
        $money = $this->makeMoney();
        $this->assertSame("£1.00", (string)$money);
    }

    /**
     *
     */
    public function testPounds()
    {
        $money = $this->makeMoney();
        $this->assertEquals(1, $money->getAmountInPounds());
    }

    /**
     *
     */
    public function testFromPounds()
    {
        $money = Money::fromPounds(1);
        $this->assertEquals(100, $money->getAmount());
    }

    /**
     *
     */
    public function testStringCreation()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new Money("100");
    }

    /**
     *
     */
    public function testFloatCreation()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new Money(100.00);
    }

    /**
     * @return Money
     */
    protected function makeMoney()
    {
        return new Money(100);
    }
}