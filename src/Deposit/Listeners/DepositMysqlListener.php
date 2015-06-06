<?php
namespace FullRent\Core\Deposit\Listeners;

use FullRent\Core\Deposit\Events\DepositSetUp;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class DepositMysqlListener
 *
 * Denormalize the Deposit Events into mysql
 *
 * @package FullRent\Core\Deposit\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositMysqlListener
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
     * When a deposit is setup, save this into mysql database
     * @param DepositSetUp $e
     * @hears("FullRent.Core.Deposit.Events.DepositSetUp")
     */
    public function whenDepositSetUp(DepositSetUp $e)
    {
        $this->db
            ->query()
            ->table('deposits')
            ->insert([
                         'id'                  => $e->getDepositId(),
                         'contract_id'         => $e->getContractId(),
                         'tenant_id'           => $e->getTenantId(),
                         'deposit_amount'      => $e->getDepositAmount()->getAmountInPounds(),
                         'deposit_due'         => $e->getDepositDue(),
                         'fullrent_collection' => $e->getFullrentCollection(),
                         'setup_at'            => $e->getSetupAt(),
                     ]);
    }
}