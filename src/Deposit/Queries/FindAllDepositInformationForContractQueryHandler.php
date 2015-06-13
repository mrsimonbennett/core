<?php
namespace FullRent\Core\Deposit\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Class FindAllDepositInformationForContractQueryHandler
 * @package FullRent\Core\Deposit\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindAllDepositInformationForContractQueryHandler implements QueryHandler
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

    public function handle(FindAllDepositInformationForContractQuery $query)
    {
        $deposits = $this->db->query()->table('deposits')->where('contract_id', $query->getContractId())->get();
        if ($deposits == null) {
            throw new ContractNotFound();
        }
        foreach ($deposits as $deposit) {
            $deposit->tenant = $this->db->query()->table('users')->where('id', '=', $deposit->tenant_id)
                                         ->first();
        }


        return $deposits;
    }
}