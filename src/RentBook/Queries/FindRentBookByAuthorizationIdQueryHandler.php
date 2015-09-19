<?php
namespace FullRent\Core\RentBook\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindRentBookByAuthorizationIdQueryHandler
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookByAuthorizationIdQueryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindRentBookByAuthorizationIdQueryHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function handle(FindRentBookByAuthorizationIdQuery $query)
    {
        return $this->client->query()
                            ->table('rent_books')
                            ->where('pre_auth_id', $query->getPreAuthorizationId())
                            ->first();
    }
}