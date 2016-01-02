<?php
namespace FullRent\Core\Listeners\Email;

use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Events\InvitedNewUserToTenancy;
use FullRent\Core\Tenancy\Queries\FindTenancyById;
use FullRent\Core\User\Events\UserFinishedApplication;
use FullRent\Core\User\Queries\FindUserById;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class TenancyEmailListener
 * @package FullRent\Core\Listeners\Email
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyEmailListener implements Subscriber
{
    /** @var QueryBus */
    private $queryBus;

    /** @var EmailClient */
    private $emailClient;

    /**
     * TenancyEmailListener constructor.
     * @param QueryBus $queryBus
     * @param EmailClient $emailClient
     */
    public function __construct(QueryBus $queryBus, EmailClient $emailClient)
    {
        $this->queryBus = $queryBus;
        $this->emailClient = $emailClient;
    }

    /**
     * @param InvitedNewUserToTenancy $e
     */
    public function invitedNewUserToTenancy(InvitedNewUserToTenancy $e)
    {

        $company = $this->queryBus->query(new FindCompanyByIdQuery((string)$e->getCompanyId()));
        $this->emailClient->send('users.invited',
                                 'You Have been invited To Fullrent',
                                 [
                                     'company' => $company,
                                     'token'   => $e->getInviteCode()->getCode(),
                                     'tenancy' => $this->queryBus->query(new FindTenancyById($e->getId()))
                                 ],
                                 '',
                                 $e->getTenantEmail());
    }

    /**
     * @param UserFinishedApplication $e
     */
    public function whenUserFinishedApplication(UserFinishedApplication $e)
    {
        $user = $this->queryBus->query(new FindUserById($e->getUserId()));
        $company = current($user->companies);


        $this->emailClient->send('users.finished_application',
                                 'Thank you for joining FullRent',
                                 ['company' => $company, 'user' => $user, 'name' => $e->getName()->getKnowAs()],
                                 $e->getName()->getKnowAs(),
                                 $user->email
        );
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
            InvitedNewUserToTenancy::class => ['invitedNewUserToTenancy', 100],
            UserFinishedApplication::class => ['whenUserFinishedApplication', 100],
        ];
    }
}