<?php
namespace FullRent\Core\Contract\Listeners;

use FullRent\Core\Application\Events\ApplicationApproved;
use FullRent\Core\Application\Query\ApplicationReadRepository;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Contract\Commands\DraftContractFromApplication;
use FullRent\Core\Contract\Commands\JoinTenantToContract;

/**
 * Class ApplicationListener
 * @package FullRent\Core\Contract\Listerners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationListener
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var ApplicationReadRepository
     */
    private $applicationReadRepository;

    /**
     * @param CommandBus $commandBus
     * @param ApplicationReadRepository $applicationReadRepository
     */
    public function __construct(CommandBus $commandBus, ApplicationReadRepository $applicationReadRepository)
    {
        $this->commandBus = $commandBus;
        $this->applicationReadRepository = $applicationReadRepository;
    }

    /**
     * @param ApplicationApproved $event
     * @hears("FullRent.Core.Application.Events.ApplicationApproved")
     * @repeatable(false)
     */
    public function whenApplicationApproved(ApplicationApproved $event)
    {
        $application = $this->applicationReadRepository->getById($event->getApplicationId());
        $contractId = uuid();

        $this->commandBus->execute(new DraftContractFromApplication($contractId,
                                                                    (string)$event->getApplicationId(),
                                                                    $application->property_id,
                                                                    $application->property->company_id,
                                                                    $application->property->landlord_id));
        $this->commandBus->execute(new JoinTenantToContract($contractId, $application->applicant_id));
    }
}