<?php
namespace FullRent\Core\Projections\PropertyHistory\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindPropertyHistoryHandler
 * @package FullRent\Core\Projections\PropertyHistory\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertyHistoryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindPropertyHistoryHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function handle(FindPropertyHistory $query)
    {
        return $this->client->query()
                            ->table('property_history')
                            ->where('property_id', $query->getPropertyId())
                            ->orderBy('event_happened', 'desc')
                            ->get();

    }
}