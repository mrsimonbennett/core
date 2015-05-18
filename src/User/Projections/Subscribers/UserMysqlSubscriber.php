<?php
namespace FullRent\Core\User\Projections\Subscribers;

use Carbon\Carbon;
use FullRent\Core\User\Events\UserRegistered;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class UserMysqlSubscriber
 * @package FullRent\Core\User\Projections\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserMysqlSubscriber
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
     * @param UserRegistered $userRegistered
     * @hears("FullRent.Core.User.Events.UserRegistered")
     */
    public function whenUserRegistered(UserRegistered $userRegistered)
    {
        $this->db->table('users')->insert([
                                              'id'          => $userRegistered->getUserId(),
                                              'legal_name'  => $userRegistered->getName()->getLegalName(),
                                              'known_as'    => $userRegistered->getName()->getKnowAs(),
                                              'email'       => $userRegistered->getEmail(),
                                              'password'    => $userRegistered->getPassword(),
                                              'created_at'  => $userRegistered->getCreatedAt(),
                                              'has_address' => false,
                                              'updated_at'  => Carbon::now(),
                                          ]);
    }
}