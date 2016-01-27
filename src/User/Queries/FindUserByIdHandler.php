<?php
namespace FullRent\Core\User\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\User\Exceptions\UserNotFound;

/**
 * Class FindUserByIdHandler
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindUserByIdHandler
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindUserById $query
     * @return mixed|static
     * @throws UserNotFound
     */
    public function handle(FindUserById $query)
    {
        if (is_null($user = $this->client->query()->table('users')->where('id', $query->getUserId())->first())) {
            throw new UserNotFound();
        } else {
            if ($query->isWithCompany()) {
                $companies = $this->client->query()->table('companies')
                                      ->join('company_users', 'company_users.company_id', '=', 'companies.id')
                                      ->where('company_users.user_id', $user->id)
                                      ->get();
                $user->companies = $companies;
            }

            return $user;
        }
    }
}