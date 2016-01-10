<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Company\Commands\EnrolTenant;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\PropertyId;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class ApplicationEventListener
 * @package FullRent\Core\CompanyModal\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationEventListener implements Subscriber
{

    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var PropertiesReadRepository
     */
    private $propertiesReadRepository;

    /**
     * @param CommandBus $bus
     * @param PropertiesReadRepository $propertiesReadRepository
     */
    public function __construct(CommandBus $bus, PropertiesReadRepository $propertiesReadRepository)
    {
        $this->bus = $bus;
        $this->propertiesReadRepository = $propertiesReadRepository;
    }

    /**
     * @param StartedApplication $e
     */
    public function whenApplicationIsStarted(StartedApplication $e)
    {
        $property = $this->propertiesReadRepository->getById(PropertyId::fromIdentity($e->getPropertyId()));
        $this->bus->execute(new EnrolTenant($property->company_id, (string)$e->getApplicantId()));
    }


    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [StartedApplication::class => ['whenApplicationIsStarted']];
    }
}