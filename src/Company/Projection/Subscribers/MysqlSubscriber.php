<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\Projection\Company;
use FullRent\Core\ValueObjects\DateTime;
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
        $this->db->table('companies')->insert([
                                                'id'         => (string)$beenRegistered->getCompanyId(),
                                                'name'       => $beenRegistered->getCompanyName()->getName(),
                                                'domain'     => $beenRegistered->getCompanyDomain()->getDomain(),
                                                'created_at' => $beenRegistered->getCreatedAt(),
                                                'updated_at' => DateTime::now(),
                                            ]);
    }

    /**
     * @param LandlordEnrolled $landlordEnrolled
     * @hears("FullRent.Core.Company.Events.LandlordEnrolled")
     */
    public function whenLandlordEnrolls(LandlordEnrolled $landlordEnrolled)
    {
        $this->db->table('company_users')->insert([
                                                      'user_id'    => $landlordEnrolled->getLandlord()->getLandlordId(),
                                                      'company_id' => $landlordEnrolled->getCompanyId(),
                                                      'role'       => 'landlord',
                                                  ]);
    }
}