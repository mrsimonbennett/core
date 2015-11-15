<?php
namespace Domain\Deposits;

use FullRent\Core\Deposit\Deposit;
use FullRent\Core\Deposit\Events\DepositManuallyPaid;
use FullRent\Core\Deposit\Events\DepositPaid;
use FullRent\Core\Deposit\Events\DepositSetUp;
use FullRent\Core\Deposit\Exceptions\DepositAlreadyPaidException;
use FullRent\Core\Deposit\Exceptions\PaymentIncorrectException;
use FullRent\Core\Deposit\ValueObjects\CardDetails;
use FullRent\Core\Deposit\ValueObjects\ContractId;
use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Deposit\ValueObjects\PaymentAmount;
use FullRent\Core\Deposit\ValueObjects\TenantId;
use FullRent\Core\Services\CardPayment\CardPaymentGateway;
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
     * @
     */
    public function testPayingDepositWithWrongAmount()
    {


        $deposit = $this->buildDeposit();
       // $deposit->fullPayment($this->buildCard(), $this->app->make(CardPaymentGateway::class));
    }


    /**
     * @return Deposit
     */
    private function buildDeposit()
    {
        return Deposit::setup(DepositId::random(),
                                  ContractId::random(),
                                  TenantId::random(),
                                  new DepositAmount(100),
                                  DateTime::now(),
                                  true);
    }

    /**
     * @return CardDetails
     */
    private function buildCard()
    {
        return new CardDetails('4242424242424242', 10, 2016, 123, 'Mr Simon Benentt');
    }
}