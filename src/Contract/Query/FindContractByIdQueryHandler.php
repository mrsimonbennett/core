<?php
namespace FullRent\Core\Contract\Query;

use FullRent\Core\Contract\Exceptions\ContractNotFound;
use FullRent\Core\QueryBus\QueryHandler;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class FindContractByIdQueryHandler
 * @package FullRent\Core\Contract\Query
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindContractByIdQueryHandler implements QueryHandler
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param FindContractByIdQuery $query
     * @return \stdClass
     * @throws ContractNotFound
     */
    public function handle(FindContractByIdQuery $query)
    {
        $contract = $this->db->table('contracts')->where('id', $query->getContractId())->first();
        if ($contract == null) {
            throw new ContractNotFound();
        }
        $contract->tenants = $this->db->table('contract_tenants')
                                      ->where('contract_id', $query->getContractId())
                                      ->join('users', 'users.id', '=', 'contract_tenants.tenant_id')
                                      ->get();

        return $contract;
    }
}