<?php
namespace FullRent\Core\Tenancy\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindTenancyRentBookPaymentHandler
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyRentBookPaymentHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindTenancyRentBookPaymentHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindTenancyRentBookPayment $query
     * @return mixed|static
     */
    public function handle(FindTenancyRentBookPayment $query)
    {
        return $this->client->query()
                            ->table('tenancy_rent_book_payments')
                            ->where('id', $query->getPaymentId())
                            ->where('deleted_at', null)
                            ->orderBy('payment_due', 'asc')
                            ->first();
    }
}