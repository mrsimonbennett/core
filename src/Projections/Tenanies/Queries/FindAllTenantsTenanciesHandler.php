<?php
namespace FullRent\Core\Projections\Tenanies\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindAllTenantsTenanciesHandler
 * @package FullRent\Core\Projections\Tenanies\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAllTenantsTenanciesHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindAllTenantsTenanciesHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindAllTenantsTenancies $query
     * @return \stdClass
     */
    public function handle(FindAllTenantsTenancies $query)
    {
        $tenancies = $this->client->query()
                                  ->table('tenancy_tenants')
                                  ->where('tenant_id', $query->getTenantId())
                                  ->join('tenancies', 'tenancies.id', '=', 'tenancy_tenants.tenancy_id')
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