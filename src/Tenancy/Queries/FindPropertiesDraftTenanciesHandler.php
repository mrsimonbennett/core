<?php
namespace FullRent\Core\Tenancy\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindPropertiesDraftTenanciesHandler
 * @package FullRent\Core\Tenancy\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertiesDraftTenanciesHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindPropertiesDraftTenanciesHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindPropertiesDraftTenancies $query
     * @return array|static[]
     */
    public function handle(FindPropertiesDraftTenancies $query)
    {
        return $this->client->query()
                            ->table('tenancies')
                            ->where('property_id', $query->getPropertyId())
                            ->where('status', 'draft')
                            ->get();
    }
}