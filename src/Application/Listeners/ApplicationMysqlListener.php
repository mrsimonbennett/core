<?php
namespace FullRent\Core\Application\Listeners;

use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\ApplicantProvidedRentingInformation;
use FullRent\Core\Application\Events\ApplicationApproved;
use FullRent\Core\Application\Events\ApplicationFinished;
use FullRent\Core\Application\Events\ApplicationRejected;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Infrastructure\Subscribers\BaseMysqlSubscriber;

/**
 * Class ApplicationMysqlListener
 * @package FullRent\Core\Application\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationMysqlListener extends BaseMysqlSubscriber
{
    /**
     * @param StartedApplication $startedApplication
     * @hears("FullRent.Core.Application.Events.StartedApplication")
     */
    public function whenApplicationWasStarted(StartedApplication $startedApplication)
    {
        $this->db
            ->table('applications')
            ->insert(
                [
                    'id'           => $startedApplication->getApplicationId(),
                    'applicant_id' => $startedApplication->getApplicantId(),
                    'property_id'  => $startedApplication->getPropertyId(),
                    'started_at'   => $startedApplication->getStartedAt()
                ]
            );
    }

    /**
     * @param ApplicantAboutInformationProvided $aboutInformationProvided
     * @hears("FullRent.Core.Application.Events.ApplicantAboutInformationProvided")
     */
    public function whenApplicationAboutInformationProvided(ApplicantAboutInformationProvided $aboutInformationProvided)
    {
        $this->db
            ->table('applications')
            ->where('id', $aboutInformationProvided->getApplicationId())
            ->update(
                [
                    'about_description' => $aboutInformationProvided->getAboutYouApplication()->getAboutYou()
                                                                    ->getAboutInformation(),
                    'date_of_birth'     => $aboutInformationProvided->getAboutYouApplication()->getDateOfBirth()
                                                                    ->getDateOfBirth(),
                    'phone_number'      => $aboutInformationProvided->getAboutYouApplication()->getPhoneNumber()
                                                                    ->getPhoneNumber()
                ]
            );


    }

    /**
     * @param ApplicantProvidedRentingInformation $event
     * @hears("FullRent.Core.Application.Events.ApplicantProvidedRentingInformation")
     */
    public function whenApplicantSubmitsRentingInformation(ApplicantProvidedRentingInformation $event)
    {
        $this->db
            ->table('applications')
            ->where('id', $event->getApplicationId())
            ->update(
                [
                    'currently_renting' => $event->getRentingInformation()->isCurrentlyRenting(),
                ]
            );
    }

    /**
     * @param ApplicationFinished $event
     * @hears("FullRent.Core.Application.Events.ApplicationFinished")
     */
    public function whenApplicationFinishes(ApplicationFinished $event)
    {
        $this->db
            ->table('applications')
            ->where('id', $event->getApplicationId())
            ->update(
                [
                    'finished'    => true,
                    'finished_at' => $event->getFinishedAt(),
                ]
            );
    }

    /**
     * @param ApplicationRejected $event
     * @hears("FullRent.Core.Application.Events.ApplicationRejected")
     */
    public function whenApplicationRejected(ApplicationRejected $event)
    {
        $this->db
            ->table('applications')
            ->where('id', $event->getApplicationId())
            ->update(
                [
                    'finished'        => false,
                    'rejected'        => true,
                    'rejected_reason' => $event->getRejectReason(),
                ]
            );
    }

    /**
     * @param ApplicationApproved $e
     * @hears("FullRent.Core.Application.Events.ApplicationApproved")
     */
    public function whenApplicationApproved(ApplicationApproved $e)
    {
        $this->db
            ->table('applications')
            ->where('id', $e->getApplicationId())
            ->update(
                [
                    'finished'    => true,
                    'rejected'    => false,
                    'approved'    => true,
                    'approved_at' => $e->getApprovedAt()
                ]
            );
    }
}