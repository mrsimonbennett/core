<?php
namespace FullRent\Core\Company\Projection\Subscribers;

use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\EnrolTenant;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\PropertyId;

/**
 * Class ApplicationEventListener
 * @package FullRent\Core\Company\Projection\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationEventListener extends EventListener
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
    protected function registerOnce()
    {
        return ['whenApplicationIsStarted' => StartedApplication::class];
    }

    protected function register()
    {
        return [];
    }
}