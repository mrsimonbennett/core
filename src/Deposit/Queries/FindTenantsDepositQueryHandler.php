<?php
namespace FullRent\Core\Deposit\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Find the deposit information for a tenant on a contract
 *
 * Class FindTenantsDepositQueryHandler
 * @package FullRent\Core\Deposit\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindTenantsDepositQueryHandler implements QueryHandler
{
    /**
     * @var MySqlClient
     */
    private $db;

    /**
     * @param MySqlClient $db
     */
    public function __construct(MySqlClient $db)
    {
        $this->db = $db;
    }

    /**
     * @param FindTenantsDepositQuery $query
     * @return mixed|static
     */
    public function handle(FindTenantsDepositQuery $query)
    {
        $deposit = $this->db
            ->query()
            ->table('deposits')
            ->where('contract_id', $query->getContractId())
            ->where('tenant_id', $query->getTenantId())
            ->first();

        $deposit->tenant = $this->db
            ->query()
            ->table('users')
            ->where('id', '=', $query->getTenantId())
            ->first();

        return $deposit;
    }
}