<?php
namespace FullRent\Core\Company\Queries;

use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\QueryBus\QueryHandler;

/**
 * Class FindCompanyByDomainQueryHandler
 * @package FullRent\Core\CompanyModal\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyByDomainQueryHandler implements QueryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindCompanyByDomainQueryHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindCompanyByDomainQuery $query
     * @return mixed|static
     * @throws CompanyNotFoundException
     */
    public function handle(FindCompanyByDomainQuery $query)
    {
        if (is_null($company = $this->client->query()->table('companies')
                                            ->where('domain', $query->getDomain())
                                            ->first())) {
            throw new CompanyNotFoundException();
        } else {
            $users = $this->client->query()->table('users')
                                  ->join('company_users', 'company_users.user_id', '=', 'users.id')
                                  ->where('company_users.company_id', $company->id)
                                  ->get();

            $company->users = $users;

            return $company;
        }
    }
}