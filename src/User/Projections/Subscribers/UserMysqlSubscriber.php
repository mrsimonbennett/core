<?php
namespace FullRent\Core\User\Projections\Subscribers;

use Carbon\Carbon;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\User\Events\UserFinishedApplication;
use FullRent\Core\User\Events\UserInvited;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Events\UserRegistered;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class UserMysqlSubscriber
 * @package FullRent\Core\User\Projections\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserMysqlSubscriber extends EventListener
{
    protected $priority = 10;

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
                                              'completed'   => true,
                                              'updated_at'  => Carbon::now(),
                                          ]);
    }

    /**
     * @param UserInvited $e
     */
    public function whenUserInvited(UserInvited $e)
    {
        $this->db->table('users')->insert([
                                              'id'          => $e->getUserId(),
                                              'legal_name'  => 'Pending',
                                              'known_as'    => 'Pending',
                                              'email'       => $e->getEmail(),
                                              'password'    => null,
                                              'created_at'  => $e->getInvitedAt(),
                                              'has_address' => false,
                                              'updated_at'  => Carbon::now(),
                                              'completed'   => false
                                          ]);
    }

    /**
     * @param UserFinishedApplication $e
     */
    public function whenUserFinishedApplication(UserFinishedApplication $e)
    {
        $this->db->table('users')
                 ->where('id', $e->getUserId())
                 ->update([
                              'legal_name' => $e->getName()->getLegalName(),
                              'known_as'   => $e->getName()->getKnowAs(),
                              'password'   => $e->getPassword(),
                              'updated_at' => $e->getFinishedAt(),
                              'completed'  => true
                          ]);
    }

    /**
     * @param UserPasswordReset $e
     */
    public function whenUserPasswordReset(UserPasswordReset $e)
    {
        $this->db->table('users')
                 ->where('id', $e->getUserId())
                 ->update(['password' => $e->getPassword()]);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenUserRegistered'    => UserRegistered::class,
            'whenUserPasswordReset' => UserPasswordReset::class,
            'whenUserInvited'       => UserInvited::class,
            'whenUserFinishedApplication' => UserFinishedApplication::class,
        ];
    }
}