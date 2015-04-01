<?php
namespace FullRent\Core\Infrastructure\Subscribers;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class BaseMysqlSubscriber
 * @package FullRent\Core\Infrastructure\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
class BaseMysqlSubscriber
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

}