<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\CommandBus\CommandHandler;

/**
 * Class SubmitRentingInformationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubmitRentingInformationHandler
{
    /**
     * @var ApplicationRepository
     */
    private $applicationRepository;

    /**
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }
    public function handle(SubmitRentingInformation $command)
    {
        $application = $this->applicationRepository->load($command->getApplicationId());

        $application->submitRentingInformation($command->getRentingInformation());

        $this->applicationRepository->save($application);
    }
}