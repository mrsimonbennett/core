<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\CompanySetUpDirectDebit;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\Events\TenantEnrolled;
use FullRent\Core\Company\Projection\Company;
use FullRent\Core\ValueObjects\DateTime;
use Illuminate\Database\Connection;

/**
 * Class MysqlSubscriber
 * @package FullRent\Core\Company\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlCompanySubscriber
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
     * @hears("FullRent.Core.Company.Events.CompanyHasBeenRegistered",)
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

    /**
     * @param TenantEnrolled $e
     * @hears("FullRent.Core.Company.Events.TenantEnrolled")
     */
    public function whenTenantEnrolled(TenantEnrolled $e)
    {
        $this->db->table('company_users')->insert([
                                                      'user_id'    => $e->getTenantId(),
                                                      'company_id' => $e->getCompanyId(),
                                                      'role'       => 'tenant',
                                                  ]);
    }

    /**
     * @param CompanySetUpDirectDebit $e
     * @hears("FullRent.Core.Company.Events.CompanySetUpDirectDebit")
     */
    public function whenCompanySetUpDirectDebit(CompanySetUpDirectDebit $e)
    {
        $this->db
            ->table('companies')
            ->where('id', $e->getCompanyId())
            ->update(
                [
                    'gocardless_merchant' => $e->getMerchantId(),
                    'gocardless_token'    => $e->getAccessToken(),
                    'gocardless_setup_at' => $e->getSetupAt(),
                    'direct_debit_setup'  => true,
                ]);
    }

}