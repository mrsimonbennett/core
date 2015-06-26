<?php
namespace FullRent\Core\RentBook;

use Assert\Assertion;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\RentBook\Events\RentBookOpenedAutomatic;
use FullRent\Core\RentBook\Events\RentDueSet;
use FullRent\Core\RentBook\ValueObjects\ContractId;
use FullRent\Core\RentBook\ValueObjects\RentAmount;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\RentBook\ValueObjects\TenantId;
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
     * @var Collection
     */
    private $rentPaymentDates;

    /**
     * Set up a rent payment dates collection helper
     */
    private function __construct()
    {
        $this->rentPaymentDates = new Collection();
    }

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
     * Store the rent book id and the rent amount due each month
     *
     * @param RentBookOpenedAutomatic $e
     */
    protected function applyRentBookOpenedAutomatic(RentBookOpenedAutomatic $e)
    {
        $this->id = $e->getRentBookId();
        $this->rentAmount = $e->getRentAmount();
    }

    /**
     * Store the dates that rent is due
     *
     * @param RentDueSet $e
     */
    protected function applyRentDue(RentDueSet $e)
    {
        $this->rentPaymentDates->push(new RentBookRent($e->getRentBookRentId(),
                                                       $e->getPaymentDue(),
                                                       $this->rentAmount));
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'rent_book' . $this->id;
    }
}