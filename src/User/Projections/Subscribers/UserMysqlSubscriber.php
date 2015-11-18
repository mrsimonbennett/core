<?php
namespace FullRent\Core\User\Projections\Subscribers;

use Carbon\Carbon;
use FullRent\Core\User\Events\UserAmendedName;
use FullRent\Core\User\Events\UserChangedPassword;
use FullRent\Core\User\Events\UserFinishedApplication;
use FullRent\Core\User\Events\UserInvited;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class UserMysqlSubscriber
 * @package FullRent\Core\User\Projections\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserMysqlSubscriber implements Projection, Subscriber
{
    /** @var int */
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
                                              'timezone'    => $userRegistered->getTimezone(),
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
     * @param UserAmendedName $e
     */
    public function whenUserAmendsName(UserAmendedName $e)
    {
        $this->db->table('users')
                 ->where('id', $e->getUserId())
                 ->update([
                              'legal_name' => $e->getName()->getLegalName(),
                              'known_as'   => $e->getName()->getKnowAs(),
                          ]);
    }

    /**
     * @param UsersEmailHasChanged $e
     */
    public function whenUserUpdatesEmail(UsersEmailHasChanged $e)
    {
        $this->db->table('users')
                 ->where('id', $e->getId())
                 ->update([
                              'email' => $e->getEmail()->getEmail(),
                          ]);
    }

    /**
     * @param UserChangedPassword $e
     */
    public function whenUserChangesPassword(UserChangedPassword $e)
    {
        $this->db->table('users')
                 ->where('id', $e->getUserId())
                 ->update(['password' => $e->getNewPassword()]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            UserRegistered::class          => ['whenUserRegistered'],
            UserPasswordReset::class       => ['whenUserPasswordReset'],
            UserInvited::class             => ['whenUserInvited'],
            UserFinishedApplication::class => ['whenUserFinishedApplication'],
            UserAmendedName::class         => ['whenUserAmendsName'],
            UsersEmailHasChanged::class    => ['whenUserUpdatesEmail'],
            UserChangedPassword::class     => ['whenUserChangesPassword'],
        ];
    }
}