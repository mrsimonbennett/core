<?php
namespace FullRent\Core\Subscription\Listeners;

use FullRent\Core\Company\Events\CompanyHasBeenRegistered;
use FullRent\Core\Subscription\Commands\StartCompanyTrail;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class CompanyRegisteredListener
 * @package FullRent\Core\Subscription\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyRegisteredListener implements Subscriber
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * CompanyRegisteredListener constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * When A company registered fire off event for starting the trail
     * @param CompanyHasBeenRegistered $e
     */
    public function whenCompanyRegistered(CompanyHasBeenRegistered $e)
    {
        $this->commandBus->execute(new StartCompanyTrail((string)$e->getCompanyId(), uuid()));
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            CompanyHasBeenRegistered::class => ['whenCompanyRegistered'],
        ];
    }
}