<?php
namespace FullRent\Core\Tenancy\Listeners;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Tenancy\Events\RemovedScheduledRentPayment;
use FullRent\Core\Tenancy\Events\TenancyRentPaymentScheduled;
use FullRent\Core\Tenancy\Events\TenancyRentScheduledPaymentAmended;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class TenancyRentBookListener
 * @package FullRent\Core\Tenancy\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyRentBookListener implements Projection, Subscriber
{
    /** @var MySqlClient */
    private $client;

    /**
     * TenancyRentBookListener constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param TenancyRentPaymentScheduled $e
     */
    public function whenTenancyRentPaymentScheduled(TenancyRentPaymentScheduled $e)
    {
        $this->client->query()
                     ->table('tenancy_rent_book_payments')
                     ->insert([
                                  'id'             => $e->getRentPaymentId(),
                                  'tenancy_id'     => $e->getId(),
                                  'payment_due'    => $e->getDue(),
                                  'payment_amount' => $e->getRentAmount()->getAmountInPounds(),
                              ]);
    }

    /**
     * @param TenancyRentScheduledPaymentAmended $e
     */
    public function whenTenancyRentScheduledPaymentAmended(TenancyRentScheduledPaymentAmended $e)
    {
        $this->client->query()
                     ->table('tenancy_rent_book_payments')
                     ->where('id', $e->getRentPaymentId())
                     ->update([
                                  'payment_due'    => $e->getDue(),
                                  'payment_amount' => $e->getRentAmount()->getAmountInPounds(),
                              ]);
    }

    /**
     * @param RemovedScheduledRentPayment $e
     */
    public function whenRemovedScheduledRentPayment(RemovedScheduledRentPayment $e)
    {
        $this->client->query()
                     ->table('tenancy_rent_book_payments')
                     ->where('id', $e->getRentPaymentId())
                     ->update(['deleted_at' => $e->getRemovedAt()]);
    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            TenancyRentPaymentScheduled::class        => 'whenTenancyRentPaymentScheduled',
            TenancyRentScheduledPaymentAmended::class => 'whenTenancyRentScheduledPaymentAmended',
            RemovedScheduledRentPayment::class        => 'whenRemovedScheduledRentPayment',
        ];
    }
}