<?php
namespace FullRent\Core\Application;

use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\ApplicantProvidedRentingInformation;
use FullRent\Core\Application\Events\ApplicationApproved;
use FullRent\Core\Application\Events\ApplicationFinished;
use FullRent\Core\Application\Events\ApplicationRejected;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Application\Exceptions\ApplicationNotFinished;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\Application\ValueObjects\RejectReason;
use FullRent\Core\Application\ValueObjects\RentingInformation;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Application
 * @package FullRent\Core\Application
 * @author Simon Bennett <simon@bennett.im>
 */
final class Application extends AggregateRoot
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

    /**
     * @param RentingInformation $rentingInformation
     */
    public function submitRentingInformation(RentingInformation $rentingInformation)
    {
        $this->apply(new ApplicantProvidedRentingInformation($this->applicationId, $rentingInformation));
    }

    /**
     * @param DateTime $finishedAt
     * @throws ApplicationNotFinished
     */
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
     * @param RejectReason $reason
     * @param DateTime $rejectedAt
     * @throws ApplicationNotFinished
     */
    public function reject(RejectReason $reason, DateTime $rejectedAt = null)
    {
        if ($this->editable) {
            // throw new ApplicationNotFinished;
        }
        if (is_null($rejectedAt)) {
            $rejectedAt = DateTime::now();
        }

        $this->apply(new ApplicationRejected($this->applicationId, $reason, $rejectedAt));
    }

    /**
     * @param DateTime $approvedAt
     */
    public function approve(DateTime $approvedAt = null)
    {
        if (is_null($approvedAt)) {
            $approvedAt = DateTime::now();
        }

        $this->apply(new ApplicationApproved($this->applicationId, $approvedAt));
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

    /**
     * @param ApplicationFinished $applicationFinished
     */
    protected function applyApplicationFinished(ApplicationFinished $applicationFinished)
    {
        $this->editable = false;
    }

    /**
     * @param ApplicationRejected $applicationRejected
     */
    protected function applyApplicationRejected(ApplicationRejected $applicationRejected)
    {
        $this->editable = true;
    }

    /**
     * @param ApplicationApproved $applicationApproved
     */
    public function applyApplicationApproved(ApplicationApproved $applicationApproved)
    {

    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return "application-" . (string)$this->applicationId;
    }

    /**
     * @return bool
     */
    private function isComplete()
    {
        return true;
    }
}