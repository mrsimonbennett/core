<?php
namespace FullRent\Core\Deposit\Listeners;

use FullRent\Core\Deposit\Events\DepositPaid;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class DepositMySqlListenerV2
 * @package FullRent\Core\Deposit\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositMySqlListenerV2 extends EventListener
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
     * @return array
     */
    protected function register()
    {
        return [
            DepositPaid::class => 'whenDepositPaid',
        ];
    }
}