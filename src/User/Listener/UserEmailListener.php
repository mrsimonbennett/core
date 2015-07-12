<?php
namespace FullRent\Core\User\Listener;

use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Events\UserHasRequestedPasswordReset;
use FullRent\Core\User\Events\UserPasswordReset;
use FullRent\Core\User\Queries\FindUserById;

/**
 * Class EmailListener
 * @package FullRent\Core\User\Listener
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserEmailListener extends EventListener
{
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
     * @return array
     */
    protected function register()
    {
        return ['whenUserPasswordReset' => UserPasswordReset::class];
    }

    /**
     * @return array
     */
    protected function registerOnce()
    {
        return [
            'whenPasswordResetRequested' => UserHasRequestedPasswordReset::class,
        ];
    }
}