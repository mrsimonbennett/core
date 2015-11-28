<?php
namespace FullRent\Core\User\Listener;

use FullRent\Core\Company\Events\CompanyEnrolledNewTenant;
use FullRent\Core\User\Commands\InviteUser;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class ContractTenantListener
 * @package FullRent\Core\User\Listener
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractTenantListener implements Subscriber
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * ContractTenantListener constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param CompanyEnrolledNewTenant $e
     */
    public function whenCompanyEnrolledNewTenant(CompanyEnrolledNewTenant $e)
    {
        $this->commandBus->execute(new InviteUser((string)$e->getTenantId(), (string)$e->getTenantEmail()));
    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [CompanyEnrolledNewTenant::class => ['whenCompanyEnrolledNewTenant']];
    }
}