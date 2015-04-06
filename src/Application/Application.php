<?php
namespace FullRent\Core\Application;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Application\Exceptions\AboutInformationAlreadySubmittedException;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class Application
 * @package FullRent\Core\Application
 * @author Simon Bennett <simon@bennett.im>
 */
final class Application extends EventSourcedAggregateRoot
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var ApplicantId
     */
    private $applicantId;
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var DateTime
     */
    private $startedAt;
    /**
     * @var AboutYouApplication
     */
    private $aboutApplicationSection;

    public static function startApplication(
        ApplicationId $applicationId,
        ApplicantId $applicantId,
        PropertyId $propertyId
    ) {
        $application = new static();

        $application->apply(new StartedApplication($applicationId, $applicantId, $propertyId, DateTime::now()));

        return $application;
    }


    public function submitAboutInformation(AboutYouApplication $aboutYouApplication)
    {
        if(!is_null($this->aboutApplicationSection))
        {
            throw new AboutInformationAlreadySubmittedException;
        }
        $this->apply(new ApplicantAboutInformationProvided($this->applicationId, $aboutYouApplication));
    }


    protected function applyStartedApplication(StartedApplication $startedApplication)
    {
        $this->applicationId = $startedApplication->getApplicationId();
        $this->applicantId = $startedApplication->getApplicantId();
        $this->propertyId = $startedApplication->getPropertyId();
        $this->startedAt = $startedApplication->getStartedAt();
    }

    protected function applyApplicantAboutInformationProvided(
        ApplicantAboutInformationProvided $aboutInformationProvided
    ) {
        $this->aboutApplicationSection = $aboutInformationProvided->getAboutYouApplication();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return "application-" . (string)$this->applicationId;
    }
}