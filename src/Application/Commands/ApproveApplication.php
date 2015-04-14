<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ValueObjects\ApplicationId;

/**
 * Class ApproveApplication
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApproveApplication 
{
    /**
     * @var ApplicationId
     */
    private $applicationId;

    /**
     * @param ApplicationId $applicationId
     */
    public function __construct(ApplicationId $applicationId)
    {
        $this->applicationId = $applicationId;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

}