<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Projection\Company;
use Illuminate\Database\Connection;

/**
 * Class MysqlSubscriber
 * @package FullRent\Core\Company\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlSubscriber
{
    /**
     * @var Connection
     */
    private $db;

    public function __construct(\Illuminate\Database\DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param CompanyHasBeenRegistered $beenRegistered
     * @hears("FullRent.Core.Company.Events.CompanyHasBeenRegistered")
     */
    public function companyHasBeenRegistered(CompanyHasBeenRegistered $beenRegistered)
    {
        $this->db->table('company')->insert([
            'id' =>(string) $beenRegistered->getCompanyId(),
            'name' => $beenRegistered->getCompanyName()->getName(),
            'domain' => $beenRegistered->getCompanyDomain()->getDomain(),
            'created_at'=> $beenRegistered->getCreatedAt(),
        ]);
    }
}