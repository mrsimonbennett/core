<?php
namespace FullRent\Core\User\Listener;

use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Events\UserHasRequestedPasswordReset;
use FullRent\Core\User\Events\UserInvited;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Queries\FindUserById;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class EmailListener
 * @package FullRent\Core\User\Listener
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserEmailListener implements Subscriber
{
    protected $priority = 0;


    /** @var EmailClient */
    private $emailClient;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param EmailClient $emailClient
     * @param QueryBus $queryBus
     */
    public function __construct(EmailClient $emailClient, QueryBus $queryBus)
    {
        $this->emailClient = $emailClient;
        $this->queryBus = $queryBus;
    }

    /**
     * When the password reset token is created send the user a email
     *
     * @todo check the company they sent from, at the moment we are just defaulting to there first
     * @param UserHasRequestedPasswordReset $e
     */
    public function whenPasswordResetRequested(UserHasRequestedPasswordReset $e)
    {
        $user = $this->queryBus->query(new FindUserById($e->getUserId()));
        $company = current($user->companies); // @todo Fix this
        $this->emailClient->send('auth.password.reset',
                                 'Reset your Password',
                                 [
                                     'token'   => $e->getPasswordResetToken()->getCode(),
                                     'company' => $company,
                                     'user'    => $user
                                 ],
                                 $user->known_as,
                                 $e->getEmail()->getEmail());

    }

    public function whenUserPasswordReset(UserPasswordReset $e)
    {
        $user = $this->queryBus->query(new FindUserById($e->getUserId()));
        $company = current($user->companies); // @todo Fix this
        $this->emailClient->send('auth.password.has-been-reset',
                                 'Your password has been reset',
                                 [
                                     'company' => $company,
                                     'user'    => $user
                                 ],
                                 $user->known_as,
                                 $user->email);
    }

    /**
     * @param UserInvited $e
     */
    public function whenUserInvited(UserInvited $e)
    {
        $user = $this->queryBus->query(new FindUserById($e->getUserId()));
        $company = current($user->companies); // @todo Fix this
        \Log::debug(json_decode(json_encode($company), true));
        \Log::debug(json_decode(json_encode($user), true));
        \Log::debug($e->getInviteToken()->getCode());

        $this->emailClient->send('users.invited',
                                 'You Have been invited To Fullrent',
                                 [
                                     'company' => $company,
                                     'user'    => $user,
                                     'token'   => $e->getInviteToken()->getCode(),
                                 ],
                                 '',
                                 $user->email);
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
            UserHasRequestedPasswordReset::class => ['whenPasswordResetRequested', 100],
            UserPasswordReset::class             => ['whenUserPasswordReset', 100],

        ];
    }
}