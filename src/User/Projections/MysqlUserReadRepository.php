<?php
namespace FullRent\Core\User\Projections;

use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use stdClass;

/**
 * Class MysqlUserReadRepository
 * @package FullRent\Core\User\Projections
 * @author Simon Bennett <simon@bennett.im>
 */
final class MysqlUserReadRepository implements UserReadRepository
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
     * @param Email $email
     * @return stdClass
     * @throws UserNotFound
     */
    public function getByEmail(Email $email)
    {
        if (is_null($user = $this->db->table('users')->where('email', $email)->first())) {
            throw new UserNotFound();
        } else {
            return $user;
        }
    }

    /**
     * @param UserId $userId
     * @return stdClass
     * @throws UserNotFound
     */
    public function getById(UserId $userId)
    {
        if (is_null($user = $this->db->table('users')->where('id', $userId)->first())) {
            throw new UserNotFound();
        } else {
            $companies = $this->db->table('companies')
                                ->join('company_users', 'company_users.company_id', '=', 'companies.id')
                                ->where('company_users.user_id', $user->id)
                                ->get();
            $user->companies = $companies;

            return $user;
        }

    }
}