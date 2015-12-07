<?php
namespace FullRent\Core\Listeners\Email;

use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Events\InvitedNewUserToTenancy;
use FullRent\Core\Tenancy\Queries\FindTenancyById;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class TenancyEmailListener
 * @package FullRent\Core\Listeners\Email
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyEmailListener implements Subscriber, Projection
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
                                     'tenancy'  => $this->queryBus->query(new FindTenancyById($e->getId()))
                                 ],
                                 '',
                                 $e->getTenantEmail());
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
        ];
    }
}