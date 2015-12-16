<?php
namespace FullRent\Core\Projections\AuthProjection\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindAuthByEmailQueryHandler
 * @package FullRent\Core\Projections\AuthProjection\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAuthByEmailQueryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindAuthByEmailQueryHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindAuthByEmailQuery $query
     * @return mixed|static
     */
    public function handle(FindAuthByEmailQuery $query)
    {
        return $this->client->query()
                            ->table('auth')
                            ->where('email', $query->getEmail())
                            ->first();
    }
}