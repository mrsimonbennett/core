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


}