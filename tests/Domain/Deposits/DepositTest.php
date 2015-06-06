<?php
namespace Domain\Deposits;

use FullRent\Core\Deposit\Deposit;
use FullRent\Core\Deposit\Events\DepositManuallyPaid;
use FullRent\Core\Deposit\Events\DepositPaid;
use FullRent\Core\Deposit\Events\DepositSetUp;
use FullRent\Core\Deposit\Exceptions\DepositAlreadyPaidException;
use FullRent\Core\Deposit\Exceptions\PaymentIncorrectException;
use FullRent\Core\Deposit\ValueObjects\ContractId;
use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Deposit\ValueObjects\PaymentAmount;
use FullRent\Core\Deposit\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DepositTest
 * @package Domain\Deposits
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositTest extends \TestCase
{
    public function testCreatingContract()
    {
        $deposit = $this->buildDeposit();

        $events = $this->events($deposit);

        $this->assertCount(1, $events);

        $this->checkCorrectEvent($events, 0, DepositSetUp::class);
    }

    public function testPayingDeposit()
    {
        $deposit = $this->buildDeposit();

        $deposit->manuallyPaid();

        $events = $this->events($deposit);

        $this->assertCount(2, $events);

        $this->checkCorrectEvent($events, 1, DepositManuallyPaid::class);
    }


    /**
     *
     */
    public function testPayingDepositManuallyTwiceException()
    {
        $deposit = $this->buildDeposit();

        $deposit->manuallyPaid();

        $this->setExpectedException(DepositAlreadyPaidException::class);
        $deposit->manuallyPaid();
    }

    /**
     *
     */
    public function testPayingDepositWithWrongAmount()
    {
        $deposit = $this->buildDeposit();

        $this->setExpectedException(PaymentIncorrectException::class, "Tired to pay £0.10 but should have paid £1.00");
        $deposit->payment(new PaymentAmount(10));
    }

    public function testPayingDepositCorrectly()
    {

        $deposit = $this->buildDeposit();

        $deposit->payment(new PaymentAmount(100));

        $events = $this->events($deposit);

        $this->assertCount(2, $events);

        $this->checkCorrectEvent($events, 1, DepositPaid::class);
    }
    public function testPayingDepositCorrectlyTwice()
    {

        $deposit = $this->buildDeposit();

        $deposit->payment(new PaymentAmount(100));
        $this->setExpectedException(DepositAlreadyPaidException::class);

        $deposit->payment(new PaymentAmount(100));
    }

    /**
     * @return Deposit
     */
    private function buildDeposit()
    {
        $deposit = Deposit::setup(DepositId::random(),
                                  ContractId::random(),
                                  TenantId::random(),
                                  new DepositAmount(100),
                                  DateTime::now(),
                                  true);

        return $deposit;
    }
}