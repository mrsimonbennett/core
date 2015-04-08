<?php
namespace FullRent\Core\Application;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\ApplicantProvidedRentingInformation;
use FullRent\Core\Application\Events\ApplicationFinished;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Application\Exceptions\ApplicationNotFinished;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\Application\ValueObjects\RentingInformation;
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
    /**
     * @var RentingInformation
     */
    private $rentingInformation;
    /**
     * @var bool
     */
    private $editable = true;

    /**
     * @param ApplicationId $applicationId
     * @param ApplicantId $applicantId
     * @param PropertyId $propertyId
     * @return static
     */
    public static function startApplication(
        ApplicationId $applicationId,
        ApplicantId $applicantId,
        PropertyId $propertyId
    ) {
        $application = new static();

        $application->apply(new StartedApplication($applicationId, $applicantId, $propertyId, DateTime::now()));

        return $application;
    }


    /**
     * @param AboutYouApplication $aboutYouApplication
     */
    public function submitAboutInformation(AboutYouApplication $aboutYouApplication)
    {
        if (!is_null($this->aboutApplicationSection)) {
            //@todo Make this amendment
            //throw new AboutInformationAlreadySubmittedException;
        }
        $this->apply(new ApplicantAboutInformationProvided($this->applicationId, $aboutYouApplication));
    }

    public function submitRentingInformation(RentingInformation $rentingInformation)
    {
        $this->apply(new ApplicantProvidedRentingInformation($this->applicationId, $rentingInformation));
    }

    public function finish(DateTime $finishedAt = null)
    {
        if ($finishedAt == null) {
            $finishedAt = DateTime::now();
        }
        if (!$this->isComplete()) {
            throw new ApplicationNotFinished();
        }

        $this->apply(new ApplicationFinished($this->applicationId, $finishedAt));


    }

    /**
     * @param StartedApplication $startedApplication
     */
    protected function applyStartedApplication(StartedApplication $startedApplication)
    {
        $this->applicationId = $startedApplication->getApplicationId();
        $this->applicantId = $startedApplication->getApplicantId();
        $this->propertyId = $startedApplication->getPropertyId();
        $this->startedAt = $startedApplication->getStartedAt();
    }

    /**
     * @param ApplicantAboutInformationProvided $aboutInformationProvided
     */
    protected function applyApplicantAboutInformationProvided(
        ApplicantAboutInformationProvided $aboutInformationProvided
    ) {
        $this->aboutApplicationSection = $aboutInformationProvided->getAboutYouApplication();
    }

    /**
     * @param ApplicantProvidedRentingInformation $event
     */
    protected function applyApplicantProvidedRentingInformation(ApplicantProvidedRentingInformation $event)
    {
        $this->rentingInformation = $event->getRentingInformation();
    }
    protected function applyApplicationFinished(ApplicationFinished $applicationFinished)
    {
        $this->editable = false;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return "application-" . (string)$this->applicationId;
    }

    private function isComplete()
    {
        return true;
    }
}