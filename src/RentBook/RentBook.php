<?php
namespace FullRent\Core\RentBook;

use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\RentBook\Events\GoCardlessAcknowledgedRentBookBill;
use FullRent\Core\RentBook\Events\RentBookBillCancelled;
use FullRent\Core\RentBook\Events\RentBookBillCreated;
use FullRent\Core\RentBook\Events\RentBookBillFailed;
use FullRent\Core\RentBook\Events\RentBookBillPaid;
use FullRent\Core\RentBook\Events\RentBookBillWithdrawn;
use FullRent\Core\RentBook\Events\RentBookDirectDebitPreAuthorized;
use FullRent\Core\RentBook\Events\RentBookOpenedAutomatic;
use FullRent\Core\RentBook\Events\RentBookPreAuthCancelled;
use FullRent\Core\RentBook\Events\RentBookPreAuthExpired;
use FullRent\Core\RentBook\Events\RentDueSet;
use FullRent\Core\RentBook\ValueObjects\ContractId;
use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\RentBook\ValueObjects\TenantId;
use FullRent\Core\Services\DirectDebit\AccessTokens;
use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\ValueObjects\DateTime;
use Illuminate\Support\Collection;

/**
 * Class RentBook
 *
 * The Rent book for a tenant in a contract
 *
 * Each Tenant gets there own rent book, It keeps how much they owe and how much they have paid.
 *
 * Rent can either be manually paid, or can be automatically via direct debit
 *
 * @package FullRent\Core\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBook extends EventSourcedAggregateRoot
{
    /**
     * @var RentAmount
     */
    private $rentAmount;

    /**
     * @var RentBookId
     */
    private $id;

    /**
     * @var Collection|RentBookRent[]
     */
    private $rentPaymentDates;

    /**
     * @var PreAuthorization
     */
    private $preAuthToken;

    /**
     * Create Rent book for automatic payments
     *
     * @param RentBookId $rentBookId
     * @param ContractId $contractId
     * @param TenantId $tenantId
     * @param RentAmount $rentAmount
     * @param DateTime[] $paymentDates
     * @return static
     */
    public static function openRentBookAutomatic(
        RentBookId $rentBookId,
        ContractId $contractId,
        TenantId $tenantId,
        RentAmount $rentAmount,
        $paymentDates
    ) {
        $rentBook = new static();

        Assertion::allIsInstanceOf($paymentDates, DateTime::class);

        $rentBook->apply(new RentBookOpenedAutomatic($rentBookId,
                                                     $contractId,
                                                     $tenantId,
                                                     $rentAmount,
                                                     DateTime::now()));
        foreach ($paymentDates as $date) {
            $rentBook->rentDue($date);
        }

        return $rentBook;
    }

    /**
     * @param DateTime $paymentDue
     */
    public function rentDue(DateTime $paymentDue)
    {
        $this->apply(new RentDueSet($this->id, RentBookRentId::random(), $paymentDue, DateTime::now()));
    }

    /**
     * @param DirectDebit $directDebit
     * @param $resourceId
     * @param $resourceType
     * @param $resourceUri
     * @param $signature
     * @param AccessTokens $accessTokens
     */
    public function authorizeDirectDebit(
        DirectDebit $directDebit,
        $resourceId,
        $resourceType,
        $resourceUri,
        $signature,
        AccessTokens $accessTokens
    ) {

        $confirmation = $directDebit->confirmPreAuthorization($accessTokens,
                                                              $resourceId,
                                                              $resourceType,
                                                              $resourceUri,
                                                              $signature);

        $this->apply(new RentBookDirectDebitPreAuthorized($this->id, $confirmation, DateTime::now()));
    }

    /**
     * @param DirectDebit $directDebit
     * @param AccessTokens $accessTokens
     */
    public function createBills(DirectDebit $directDebit, AccessTokens $accessTokens)
    {
        foreach ($this->rentPaymentDates as $rent) {
            $bill = $directDebit->createBill($accessTokens,
                                             $this->preAuthToken,
                                             $rent->getPaymentDue()->format("F-Y") . ' Rent',
                                             $this->rentAmount->getAmountInPounds(),
                                             $rent->getPaymentDue());
            $this->apply(new RentBookBillCreated($this->id, $bill, $rent->getRentBookRentId(), DateTime::now()));
        }
    }

    /**
     * Cancel Pre Auth
     */
    public function cancelPreAuth()
    {
        $this->apply(new RentBookPreAuthCancelled($this->id, DateTime::now()));
    }

    /**
     * Expire Pre Auth
     */
    public function expirePreAuth()
    {
        $this->apply(new RentBookPreAuthExpired($this->id, DateTime::now()));
    }

    /**
     * @param string $billId GoCardless Bill Id
     */
    public function goCardlessAcknowledgingBill($billId)
    {
        $rentBookRent = $this->findRentBookRentByBillId($billId);

        $this->apply(new GoCardlessAcknowledgedRentBookBill($this->id,
                                                            $billId,
                                                            $rentBookRent->getRentBookRentId(),
                                                            DateTime::now()));
    }

    /**
     * @param string $billId GoCardless Bill Id
     */
    public function failBill($billId)
    {
        $rentBookRent = $this->findRentBookRentByBillId($billId);

        $this->apply(new RentBookBillFailed($this->id, $billId, $rentBookRent->getRentBookRentId(), DateTime::now()));
    }

    /**
     * @param $billId
     */
    public function cancelBill($billId)
    {
        $rentBookRent = $this->findRentBookRentByBillId($billId);

        $this->apply(new RentBookBillCancelled($this->id,
                                               $billId,
                                               $rentBookRent->getRentBookRentId(),
                                               DateTime::now()));
    }

    /**
     * @param $billId
     * @param DateTime $paidAt
     */
    public function payBill($billId, DateTime $paidAt)
    {
        $rentBookRent = $this->findRentBookRentByBillId($billId);

        $this->apply(new RentBookBillPaid($this->id,
                                          $billId,
                                          $rentBookRent->getRentBookRentId(),
                                          $paidAt,
                                          DateTime::now()));
    }

    /**
     * @param $billId
     */
    public function withdrawnBill($billId)
    {
        $rentBookRent = $this->findRentBookRentByBillId($billId);

        $this->apply(new RentBookBillWithdrawn($this->id,
                                               $billId,
                                               $rentBookRent->getRentBookRentId(),
                                               DateTime::now()));

    }

    /**
     * Store the rent book id and the rent amount due each month
     *
     * @param RentBookOpenedAutomatic $e
     */
    protected function applyRentBookOpenedAutomatic(RentBookOpenedAutomatic $e)
    {
        $this->rentPaymentDates = new Collection();

        $this->id = $e->getRentBookId();
        $this->rentAmount = $e->getRentAmount();
    }

    /**
     * Store the dates that rent is due
     *
     * @param RentDueSet $e
     */
    protected function applyRentDueSet(RentDueSet $e)
    {
        $this->rentPaymentDates->put(
            (string)$e->getRentBookRentId(),
            new RentBookRent($e->getRentBookRentId(),
                             $e->getPaymentDue(),
                             $this->rentAmount)
        );
    }

    /**
     * @param RentBookBillCreated $e
     */
    protected function applyRentBookBillCreated(RentBookBillCreated $e)
    {
        /** @var RentBookRent $rent */
        $rent = $this->rentPaymentDates->get((string)$e->getRentBookRentId());

        $rent->setBill($e->getBill());
    }

    /**
     * @param RentBookDirectDebitPreAuthorized $e
     */
    protected function applyRentBookDirectDebitPreAuthorized(RentBookDirectDebitPreAuthorized $e)
    {
        $this->preAuthToken = $e->getPreAuthorization();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'rent-book-' . $this->id;
    }

    /**
     * @param $billId
     * @return RentBookRent
     */
    protected function findRentBookRentByBillId($billId)
    {
        /** @var RentBookRent $rentBookRent */
        $rentBookRent = $this->rentPaymentDates->filter(function (RentBookRent $var) use ($billId) {
            return $var->getGocardlessBillId() == $billId;
        });

        return $rentBookRent;
    }
}