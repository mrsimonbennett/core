<?php
namespace FullRent\Core\Projections\AuthProjection;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\User\Events\UserChangedPassword;
use FullRent\Core\User\Events\UserFinishedApplication;
use FullRent\Core\User\Events\UserInvited;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\User\Events\UsersEmailHasChanged;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class AuthMysqlProjection
 * @package FullRent\Core\Projections\AuthProjection
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthMysqlProjection implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * AuthMysqlProjection constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param UserRegistered $e
     */
    public function whenUserRegistered(UserRegistered $e)
    {
        $this->client->query()
                     ->table('auth')
                     ->insert([
                                  'id'       => $e->getUserId(),
                                  'email'    => $e->getEmail(),
                                  'password' => $e->getPassword(),
                              ]);
    }

    /**
     * @param UserInvited $e
     */
    public function whenUserInvited(UserInvited $e)
    {
        $this->client->query()
                     ->table('auth')
                     ->insert([
                                  'id'       => $e->getUserId(),
                                  'email'    => $e->getEmail(),
                                  'password' => null,

                              ]);
    }

    /**
     * @param UserFinishedApplication $e
     */
    public function whenUserFinishedApplication(UserFinishedApplication $e)
    {
        $this->client->query()
                     ->table('auth')
                     ->where('id', $e->getUserId())
                     ->update([
                                  'password' => $e->getPassword(),
                              ]);
    }

    /**
     * @param UserPasswordReset $e
     */
    public function whenUserPasswordReset(UserPasswordReset $e)
    {
        $this->client->query()
                     ->table('auth')
                     ->where('id', $e->getUserId())
                     ->update(['password' => $e->getPassword()]);
    }

    /**
     * @param UsersEmailHasChanged $e
     */
    public function whenUserUpdatesEmail(UsersEmailHasChanged $e)
    {
        $this->client->query()
                     ->table('auth')
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
        $this->client->query()
                     ->table('auth')
                     ->where('id', $e->getUserId())
                     ->update(['password' => $e->getNewPassword()]);
    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            UserRegistered::class          => ['whenUserRegistered'],
            UserInvited::class             => ['whenUserInvited'],
            UserFinishedApplication::class => ['whenUserFinishedApplication'],
            UserPasswordReset::class       => ['whenUserPasswordReset'],
            UsersEmailHasChanged::class    => ['whenUserUpdatesEmail'],
            UserChangedPassword::class     => ['whenUserChangesPassword'],
        ];
    }
}