<?php
namespace FullRent\Core\User\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\User\Exceptions\UserNotFound;

/**
 * Class FindUserByEmailQueryHandler
 * @package FullRent\Core\User\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindUserByEmailQueryHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindUserByEmailQuery $query
     * @return mixed|static
     */
    public function handle(FindUserByEmailQuery $query)
    {
        $user = $this->client->query()
                             ->table('users')
                             ->where('email', $query->getEmail())
                             ->first();


        return $user;

    }
}