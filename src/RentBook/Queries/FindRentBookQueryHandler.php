<?php
namespace FullRent\Core\RentBook\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Class FindRentBookQueryHandler
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookQueryHandler implements QueryHandler
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
    public function handle(FindRentBookQuery $query)
    {
        return $this->client
            ->query()
            ->table('rent_books')
            ->where('contract_id',$query->getContractId())
            ->where('tenant_id',$query->getTenantId())
            ->first();
    }
}