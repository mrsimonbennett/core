<?php
namespace FullRent\Core\Tenancy\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindTenancyByIdHandler
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyByIdHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindTenancyByIdHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindTenancyById $query
     * @return mixed|static
     */
    public function handle(FindTenancyById $query)
    {
        $tenancy = $this->client->query()
                                ->table('tenancies')
                                ->where('id', $query->getTenancyId())
                                ->first();

        $tenancy->property = $this->client->query()
                                          ->table('properties')
                                          ->where('id', $tenancy->property_id)
                                          ->first();

        $tenancy->rent_book_payments = $this->client->query()
                                                    ->table('tenancy_rent_book_payments')
                                                    ->where('tenancy_id', $tenancy->id)
                                                    ->get();

        return $tenancy;
    }
}