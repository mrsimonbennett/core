<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Company\Events\CompanyNameChanged;
use FullRent\Core\Company\Events\CompanySetUpDirectDebit;
use FullRent\Core\Company\Events\LandlordEnrolled;
use FullRent\Core\Company\Events\TenantEnrolled;
use FullRent\Core\Company\Projection\Company;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\ValueObjects\DateTime;
use Illuminate\Database\Connection;

/**
 * Class MysqlSubscriber
 * @package FullRent\Core\Company\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlCompanySubscriber extends EventListener
{
    protected $priority = 10;

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

    /**
     * @param CompanyNameChanged $e
     */
    public function whenCompanyNameChanged(CompanyNameChanged $e)
    {
        $this->db
            ->table('companies')
            ->where('id', $e->getCompanyId())
            ->update(
                [
                    'name' => $e->getCompanyName()->getName(),
                ]);

    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'companyHasBeenRegistered'    => CompanyHasBeenRegistered::class,
            'whenLandlordEnrolls'         => LandlordEnrolled::class,
            'whenTenantEnrolled'          => TenantEnrolled::class,
            'whenCompanySetUpDirectDebit' => CompanySetUpDirectDebit::class,
            'whenCompanyNameChanged'      => CompanyNameChanged::class,
        ];
    }
}