<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\RejectReason;

/**
 * Class RejectApplicationHandler
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RejectApplicationHandler
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
     * @param RejectApplication $command
     */
    public function handle(RejectApplication $command)
    {
        $application = $this->applicationRepository->load(new ApplicationId($command->getApplicationId()));

        $application->reject(new RejectReason($command->getRejectReason()));

        $this->applicationRepository->save($application);
    }
}