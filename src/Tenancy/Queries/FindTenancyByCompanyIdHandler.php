<?php
namespace FullRent\Core\Tenancy\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindTenancyByCompanyIdHandler
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenancyByCompanyIdHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindTenancyByCompanyIdHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindTenancyByCompanyId $query
     * @return array|static[]
     */
    public function handle(FindTenancyByCompanyId $query)
    {
        $tenancies = $this->client->query()
                                  ->table('tenancies')
                                  ->where('company_id', $query->getCompanyId())
                                  ->get();

        foreach ($tenancies as $tenancy) {
            $tenancy->property = $this->client->query()
                                              ->table('properties')
                                              ->where('id', $tenancy->property_id)
                                              ->first();
        }

        return $tenancies;
    }
}