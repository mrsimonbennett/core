<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ApplicationRepository;

/**
 * Class ApproveApplicationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApproveApplicationHandler
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
     * @param ApproveApplication $command
     */
    public function handle(ApproveApplication $command)
    {
        $application = $this->applicationRepository->load($command->getApplicationId());
        $application->approve();
        $this->applicationRepository->save($application);
    }
}