<?php
namespace FullRent\Core\RentBook\Listeners;

use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\RentBook\Events\GoCardlessAcknowledgedRentBookBill;
use FullRent\Core\RentBook\Events\RentBookBillCancelled;
use FullRent\Core\RentBook\Events\RentBookBillCreated;
use FullRent\Core\RentBook\Events\RentBookBillFailed;
use FullRent\Core\RentBook\Events\RentBookBillPaid;
use FullRent\Core\RentBook\Events\RentBookBillWithdrawn;
use FullRent\Core\RentBook\Events\RentBookDirectDebitPreAuthorized;
use FullRent\Core\RentBook\Events\RentBookOpenedAutomatic;
use FullRent\Core\RentBook\Events\RentDueSet;

/**
 * Class RentBookMysqlListener
 * @package FullRent\Core\RentBook\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookMysqlListener extends EventListener
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function whenRentBookOpenedAutomatic(RentBookOpenedAutomatic $e)
    {
        $this->client
            ->query()
            ->table('rent_books')
            ->insert([
                         'id'          => $e->getRentBookId(),
                         'contract_id' => $e->getContractId(),
                         'tenant_id'   => $e->getTenantId(),
                         'rent_amount' => $e->getRentAmount()->getAmountInPounds(),
                         'opened_at'   => $e->getOpenedAt(),
                     ]);
    }

    /**
     * @param RentDueSet $e
     */
    public function whenRentBookPaymentDueSet(RentDueSet $e)
    {
        $this->client
            ->query()
            ->table('rent_book_rent')
            ->insert([
                         'id'           => $e->getRentBookRentId(),
                         'rent_book_id' => $e->getRentBookId(),
                         'due'          => $e->getPaymentDue()
                     ]);
    }

    /**
     * When the tenant preauthorizes there payments mark it as done
     *
     * @param RentBookDirectDebitPreAuthorized $e
     */
    public function whenRentBookSetup(RentBookDirectDebitPreAuthorized $e)
    {
        $this->client->query()
                     ->table('rent_books')
                     ->where('id', $e->getRentBookId())
                     ->update(
                         [
                             'setup'       => true,
                             'pre_auth_id' => $e->getPreAuthorization()->getId(),
                         ]
                     );
    }

    /**
     * @param RentBookBillCreated $e
     */
    public function whenRentBookBillCreated(RentBookBillCreated $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'scheduled',
                              ]);
    }

    /**
     * @param GoCardlessAcknowledgedRentBookBill $e
     */
    public function whenGoCardlessAcknowledgedRentBookBill(GoCardlessAcknowledgedRentBookBill $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'pending',
                              ]);
    }

    public function whenRentBookBillFailed(RentBookBillFailed $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'failed',
                              ]);
    }

    public function whenRentBookBillCancelled(RentBookBillCancelled $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'cancelled',
                              ]);
    }

    public function whenRentBookBillPaid(RentBookBillPaid $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'collected',
                              ]);
    }

    public function whenRentBookBillWithdrawn(RentBookBillWithdrawn $e)
    {
        $this->client->query()
                     ->table('rent_book_rent')
                     ->where('id', $e->getRentBookRentId())
                     ->update([
                                  'status' => 'withdrawn',
                              ]);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenRentBookOpenedAutomatic'            => RentBookOpenedAutomatic::class,
            'whenRentBookPaymentDueSet'              => RentDueSet::class,
            'whenRentBookSetup'                      => RentBookDirectDebitPreAuthorized::class,
            'whenRentBookBillCreated'                => RentBookBillCreated::class,
            'whenGoCardlessAcknowledgedRentBookBill' => GoCardlessAcknowledgedRentBookBill::class,
            'whenRentBookBillFailed'                 => RentBookBillFailed::class,
            'whenRentBookBillCancelled'              => RentBookBillCancelled::class,
            'whenRentBookBillPaid'                   => RentBookBillPaid::class,
            'whenRentBookBillWithdrawn'              => RentBookBillWithdrawn::class
        ];
    }
}