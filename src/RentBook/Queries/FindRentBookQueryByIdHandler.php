<?php
namespace FullRent\Core\RentBook\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Class FindRentBookQueryByIdHandler
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookQueryByIdHandler implements QueryHandler
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindRentBookQueryById $query
     * @return mixed|static
     */
    public function handle(FindRentBookQueryById $query)
    {
        return $this->client
            ->query()
            ->table('rent_books')
            ->where('id', $query->getRentBookId())
            ->first();
    }
}