<?php
namespace FullRent\Core\Projections\Properties\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindPropertiesByCompanyHandler
 * @package FullRent\Core\Projections\Properties\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertiesByCompanyHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindPropertiesByCompanyHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindPropertiesByCompany $query
     * @return array|static[]
     */
    public function handle(FindPropertiesByCompany $query)
    {
        return $this->client->query()
                            ->table('properties')
                            ->where('company_id', $query->getCompanyId())
                            ->get();

    }
}