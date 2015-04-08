<?php
namespace FullRent\Core\Company\Projection;

use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyId;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use stdClass;

/**
 * Class MySqlCompanyReadRepository
 * @package FullRent\Core\Company\Projection
 * @author Simon Bennett <simon@bennett.im>
 */
final class MySqlCompanyReadRepository implements CompanyReadRepository
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param CompanyDomain $companyDomain
     * @throws CompanyNotFoundException
     * @return stdClass
     */
    public function getByDomain(CompanyDomain $companyDomain)
    {
        if (is_null($company = $this->db->table('companies')
                                        ->where('domain', $companyDomain)
                                        ->first())) {
            throw new CompanyNotFoundException();
        } else {
            $users = $this->db->table('users')
                              ->join('company_users', 'company_users.user_id', '=', 'users.id')
                              ->where('company_users.company_id', $company->id)
                              ->get();
            $company->users = $users;

            return $company;
        }
    }

    /**
     * @param CompanyId $companyId
     * @throws CompanyNotFoundException
     * @return stdClass
     */
    public function getById(CompanyId $companyId)
    {
        if (is_null($company = $this->db->table('companies')
                                        ->where('id', $companyId)
                                        ->first())) {
            throw new CompanyNotFoundException();
        }

        return $company;
    }
}