<?php
namespace FullRent\Core\Deposit\Listeners;

use FullRent\Core\Deposit\Events\DepositPaid;
use FullRent\Core\Deposit\Events\DepositSetUp;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class DepositMySqlListenerV2
 * @package FullRent\Core\Deposit\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositMySqlListenerV2 implements Subscriber, Projection
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
     * @param DepositPaid $e
     */
    public function whenDepositPaid(DepositPaid $e)
    {
        $this->db
            ->query()
            ->table('deposits')
            ->where('id', $e->getDepositId())
            ->update([
                         'paid'    => true,
                         'paid_at' => $e->getPaidAt(),
                     ]);
    }

    /**
     * When a deposit is setup, save this into mysql database
     * @param DepositSetUp $e
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

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            DepositSetUp::class => ['whenDepositSetUp'],
            DepositPaid::class  => ['whenDepositPaid'],
        ];
    }
}