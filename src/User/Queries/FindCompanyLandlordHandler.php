<?php
namespace FullRent\Core\User\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindCompanyLandlordHandler
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyLandlordHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindCompanyLandlordHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindCompanyLandlord $query
     * @return mixed|static
     */
    public function handle(FindCompanyLandlord $query)
    {
        return $this->client->query()
                            ->table('users')
                            ->join('company_users', 'company_users.user_id', '=', 'users.id')
                            ->where('company_users.company_id', $query->getCompanyId())
                            ->where('company_users.role', 'landlord')
                            ->first();
    }
}