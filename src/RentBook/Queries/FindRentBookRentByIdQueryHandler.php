<?php
namespace FullRent\Core\RentBook\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Class FindRentBookRentByIdQueryHandler
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookRentByIdQueryHandler implements QueryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindRentBookRentByIdQueryHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function handle(FindRentBookRentByIdQuery $query)
    {
        $rent = $this->client
            ->query()
            ->table('rent_book_rent')
            ->where('id', $query->getRentId())
            ->first();

        if ($query->isDetails()) {
            $rent->history = $this->client->query()->table('rent_book_rent_history')
                                          ->where('rent_book_rent_id', $query->getRentId())->get();
        }

        return $rent;
    }
}