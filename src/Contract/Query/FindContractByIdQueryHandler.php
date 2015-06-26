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

        foreach ($contract->tenants as $tenant) {
            $rent_book = $this->db->table('rent_books')->where('contract_id', $query->getContractId())
                                          ->where('tenant_id', $tenant->id)->first();

            $tenant->rent_book = $rent_book;

            $tenant->rent_book->rent = $this->db->table('rent_book_rent')
                                                ->where('rent_book_id', $rent_book->id)
                                                ->get();
        }

        return $contract;
    }
}