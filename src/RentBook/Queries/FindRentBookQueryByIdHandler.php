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
        $rentBook = $this->client
            ->query()
            ->table('rent_books')
            ->where('id', $query->getRentBookId())
            ->first();

        if($query->isDetails())
        {
            $rentBook->contract = $this->client->query()->table('contracts')->where('id', $rentBook->contract_id)->first();
            $rentBook->tenant = $this->client->query()->table('users')->where('id', $rentBook->tenant_id)->first();

            $rentBook->rent = $this->client->query()->table('rent_book_rent')
                                                    ->where('rent_book_id', $query->getRentBookId())
                                                    ->get();
            $rentBook->property = $this->client->query()->table('properties')->where('id',$rentBook->contract->property_id)->first();

        }

        return $rentBook;

    }
}