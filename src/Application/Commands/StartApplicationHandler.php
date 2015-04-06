<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\Application;
use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\CommandBus\CommandHandler;

/**
 * Class StartApplicationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartApplicationHandler implements CommandHandler
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

    public function handle(StartApplication $command)
    {
        $application = Application::startApplication($command->getApplicationId(),
                                                     $command->getApplicantId(),
                                                     $command->getPropertyId());

        $this->applicationRepository->save($application);
    }
}