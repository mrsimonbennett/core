<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\ApplicationId;

/**
 * Class SubmitAboutInformation
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubmitAboutInformation
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var AboutYouApplication
     */
    private $aboutYouApplication;

    /**
     * @param ApplicationId $applicationId
     * @param AboutYouApplication $aboutYouApplication
     */
    public function __construct(ApplicationId $applicationId,AboutYouApplication $aboutYouApplication)
    {
        $this->applicationId = $applicationId;
        $this->aboutYouApplication = $aboutYouApplication;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return AboutYouApplication
     */
    public function getAboutYouApplication()
    {
        return $this->aboutYouApplication;
    }

}