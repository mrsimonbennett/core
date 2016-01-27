<?php
namespace FullRent\Core\Company\Listeners;

use FullRent\Core\Company\Commands\EnrolNewTenant;
use FullRent\Core\Company\Commands\EnrolTenant;
use FullRent\Core\Tenancy\Events\InvitedExistingUserToTenancy;
use FullRent\Core\Tenancy\Events\InvitedNewUserToTenancy;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class TenancyListener
 * @package FullRent\Core\CompanyModal\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenancyListener implements Subscriber
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * TenancyListener constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param InvitedExistingUserToTenancy $e
     */
    public function whenInvitedExistingUserToTenancy(InvitedExistingUserToTenancy $e)
    {
        $this->commandBus->execute(new EnrolTenant((string)$e->getCompanyId(),
                                                   (string)$e->getTenantId(),
                                                   (string)$e->getId()));
    }

    /**
     * @param InvitedNewUserToTenancy $e
     */
    public function whenInvitedNewUserToTenancy(InvitedNewUserToTenancy $e)
    {
        $this->commandBus->execute(new EnrolNewTenant((string)$e->getCompanyId(),
                                                      (string)$e->getId(),
                                                      (string)$e->getTenantId(),
                                                      (string)$e->getTenantEmail()));
    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], ['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            InvitedExistingUserToTenancy::class => 'whenInvitedExistingUserToTenancy',
            InvitedNewUserToTenancy::class      => 'whenInvitedNewUserToTenancy',
        ];
    }
}