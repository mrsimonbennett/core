<?php
namespace FullRent\Core\RentBook\Listeners;

use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\RentBook\Events\RentBookBillCreated;
use FullRent\Core\RentBook\Events\RentBookBillPaid;
use FullRent\Core\RentBook\Events\RentBookBillWithdrawn;

/**
 * Class RentBookRentHistoryListener
 * @package FullRent\Core\RentBook\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookRentHistoryListener extends EventListener
{
    /** @var MySqlClient */
    private $client;

    /**
     * RentBookRentHistoryListener constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function whenRentBookBillCreated(RentBookBillCreated $e)
    {
        $this->insertHistory([
                                 'rent_book_rent_id' => $e->getRentBookRentId(),
                                 'happened_at'       => $e->getCreatedAt(),
                                 'status'            => 'scheduled',
                                 'title'             => 'Payment created and scheduled',
                                 'description'       => 'We have requested gocardless to bill the tenant'
                             ]);
    }

    public function whenRentBookBillPaid(RentBookBillPaid $e)
    {
        $this->insertHistory([
                                 'rent_book_rent_id' => $e->getRentBookRentId(),
                                 'happened_at'       => $e->getPaidAt(),
                                 'status'            => 'collected',
                                 'title'             => 'Rent has been confirmed and received',
                                 'description'       => 'Rent has successfully been debited from the tenants account.
                                  The cash will be held by GoCardless for 3 days, after which it will be withdrawn to your bank account.'
                             ]);
    }

    public function whenRentBookBillWithdrawn(RentBookBillWithdrawn $e)
    {
        $this->insertHistory([
                                 'rent_book_rent_id' => $e->getRentBookRentId(),
                                 'happened_at'       => $e->getWithdrawnAt(),
                                 'status'            => 'withdrawn',
                                 'title'             => 'Payment withdrawn to your account',
                                 'description'       => 'Rent has been withdrawn into your account, Should be no longer than 1 business day until you receive your rent.'
                             ]);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenRentBookBillCreated'   => RentBookBillCreated::class,
            'whenRentBookBillPaid'      => RentBookBillPaid::class,
            'whenRentBookBillWithdrawn' => RentBookBillWithdrawn::class,
        ];
    }

    /**
     * @param RentBookBillCreated $e
     */
    protected function insertHistory($data)
    {
        $this->client->query()
                     ->table('rent_book_rent_history')
                     ->insert($data);
    }
}