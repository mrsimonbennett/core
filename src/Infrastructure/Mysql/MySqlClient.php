<?php
namespace FullRent\Core\Infrastructure\Mysql;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class MySqlClient
 * @package FullRent\Core\Infrastructure\Mysql
 * @author Simon Bennett <simon@bennett.im>
 */
final class MySqlClient
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @return Connection
     */
    public function query()
    {
        return $this->databaseManager;
    }
}