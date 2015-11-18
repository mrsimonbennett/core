<?php
namespace FullRent\Core\Deposit;

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
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Deposit
 *
 * Tenants Contract Deposit
 *
 * Used to manage payments of deposits, either using fullrent or doing it manually
 *
 * If collected by fullrent we will place in a dps and upload the documents for that.
 * Otherwise just record its been paid
 *
 * In future we may have comments threads, to solve deposits conflicts
 *
 * @package FullRent\Core\Deposit
 * @author Simon Bennett <simon@bennett.im>
 */
final class Deposit extends AggregateRoot
{
    /**
     * @var DepositId
     */
    private $depositId;

    /**
     * @var ContractId
     */
    private $contractId;

    /**
     * @var TenantId
     */
    private $tenantId;

    /**
     * @var DepositAmount
     */
    private $depositAmount;

    /**
     * @var DateTime
     */
    private $depositDue;

    /**
     * @var bool
     */
    private $fullrentCollection;

    /**
     * @var bool
     */
    private $paid;

    /**
     * Setup a tenants contract deposit
     * We need to know the amount, the due day for reference
     * Which contact its reefers to
     *
     * @param DepositId $depositId
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param DepositAmount $depositAmount
     * @param DateTime $depositDue
     * @param bool $fullrentCollection
     * @return static
     */
    public static function setup(
        DepositId $depositId,
        ContractId $contractId,
        TenantId $tenantId,
        DepositAmount $depositAmount,
        DateTime $depositDue,
        $fullrentCollection
    ) {
        $deposit = new static();

        $deposit->apply(new DepositSetUp($depositId,
                                         $contractId,
                                         $tenantId,
                                         $depositAmount,
                                         $depositDue,
                                         $fullrentCollection, DateTime::now()));

        return $deposit;
    }

    /**
     * @throws DepositAlreadyPaidException
     */
    public function manuallyPaid()
    {
        $this->guardAgainstPayingDepositMoreThanOnce();
        $this->apply(new DepositManuallyPaid($this->depositId, DateTime::now()));
    }

    /**
     * Pay deposit with payment/card normally
     *
     * We pass in the card and the service we use for card payments.
     *
     * @param CardDetails $cardDetails
     * @param CardPaymentGateway $cardPaymentGateway
     * @throws DepositAlreadyPaidException
     */
    public function fullPayment(CardDetails $cardDetails, CardPaymentGateway $cardPaymentGateway)
    {
        $this->guardAgainstPayingDepositMoreThanOnce();

        $paymentDetails = $cardPaymentGateway->charge($cardDetails, $this->depositAmount, "Payment of deposit");

        $this->apply(new DepositPaid($this->depositId,
                                     new PaymentAmount($this->depositAmount->getAmount()),
                                     $paymentDetails,
                                     DateTime::now()));

    }

    /**
     * Apply Deposit setup
     * Copy all the data needed from the event into attributes for us in this domain model
     * @param DepositSetUp $e *
     */
    protected function applyDepositSetUp(DepositSetUp $e)
    {
        $this->depositId = $e->getDepositId();
        $this->contractId = $e->getContractId();
        $this->tenantId = $e->getTenantId();
        $this->depositAmount = $e->getDepositAmount();
        $this->depositDue = $e->getDepositDue();
        $this->fullrentCollection = $e->getFullrentCollection();
    }

    /**
     * Apply the deposit was manually paid
     * We set a flag saying its been paid
     * @param DepositManuallyPaid $e
     */
    protected function applyDepositManuallyPaid(DepositManuallyPaid $e)
    {
        $this->paid = true;
    }

    /**
     * Apply the deposit was paid
     * We again set a flag to prevent double payment
     * @param DepositPaid $e
     */
    public function applyDepositPaid(DepositPaid $e)
    {
        $this->paid = true;
    }

    /**
     * return back the aggregate id
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'deposit-' . $this->depositId;
    }

    /**
     * Check the deposit has not already been paid
     * @throws DepositAlreadyPaidException
     */
    private function guardAgainstPayingDepositMoreThanOnce()
    {
        if ($this->paid) {
            throw new DepositAlreadyPaidException();
        }
    }

    /**
     * Check the payment was the correct amount
     *
     * This is the total amount the user paid, fees we take on the chin and
     * will process the cost of them in the card payment aggregate
     * @param PaymentAmount $paymentAmount
     * @throws PaymentIncorrectException
     */
    private function guardAgainstPayingIncorrectAmount(PaymentAmount $paymentAmount)
    {
        if ($paymentAmount->getAmount() !== $this->depositAmount->getAmount()) {
            throw new PaymentIncorrectException($paymentAmount, $this->depositAmount);
        }
    }
}