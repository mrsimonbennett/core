<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\CommandBus\CommandHandler;

/**
 * Class SubmutAboutInformationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubmitAboutInformationHandler
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
    public function handle(SubmitAboutInformation $command)
    {
        $application = $this->applicationRepository->load($command->getApplicationId());

        $application->submitAboutInformation($command->getAboutYouApplication());

        $this->applicationRepository->save($application);
    }
}