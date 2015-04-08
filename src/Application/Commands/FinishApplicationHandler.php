<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\CommandBus\CommandHandler;

/**
 * Class FinishApplicationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class FinishApplicationHandler implements CommandHandler
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

    /**
     * @param FinishApplication $command
     */
    public function handle(FinishApplication $command)
    {
        $application = $this->applicationRepository->load($command->getApplicationId());

        $application->finish();

        $this->applicationRepository->save($application);
    }
}