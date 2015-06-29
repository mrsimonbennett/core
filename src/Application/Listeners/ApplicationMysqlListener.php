<?php
namespace FullRent\Core\Application\Listeners;

use FullRent\Core\Application\Events\ApplicantAboutInformationProvided;
use FullRent\Core\Application\Events\ApplicantProvidedRentingInformation;
use FullRent\Core\Application\Events\ApplicationApproved;
use FullRent\Core\Application\Events\ApplicationFinished;
use FullRent\Core\Application\Events\ApplicationRejected;
use FullRent\Core\Application\Events\StartedApplication;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class ApplicationMysqlListener
 * @package FullRent\Core\Application\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationMysqlListener extends EventListener
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }
    /**
     * @param StartedApplication $e
     */
    public function whenApplicationWasStarted(StartedApplication $e)
    {
        $this->client->query()
            ->table('applications')
            ->insert(
                [
                    'id'           => $e->getApplicationId(),
                    'applicant_id' => $e->getApplicantId(),
                    'property_id'  => $e->getPropertyId(),
                    'started_at'   => $e->getStartedAt()
                ]
            );
    }

    /**
     * @param ApplicantAboutInformationProvided $e
     */
    public function whenApplicationAboutInformationProvided(ApplicantAboutInformationProvided $e)
    {
        $this->client->query()
            ->table('applications')
            ->where('id', $e->getApplicationId())
            ->update(
                [
                    'about_description' => $e->getAboutYouApplication()->getAboutYou()
                                             ->getAboutInformation(),
                    'date_of_birth'     => $e->getAboutYouApplication()->getDateOfBirth()
                                             ->getDateOfBirth(),
                    'phone_number'      => $e->getAboutYouApplication()->getPhoneNumber()
                                             ->getPhoneNumber()
                ]
            );


    }

    /**
     * @param ApplicantProvidedRentingInformation $e
     */
    public function whenApplicantSubmitsRentingInformation(ApplicantProvidedRentingInformation $e)
    {
        $this->client->query()
            ->table('applications')
            ->where('id', $e->getApplicationId())
            ->update(
                [
                    'currently_renting' => $e->getRentingInformation()->isCurrentlyRenting(),
                ]
            );
    }

    /**
     * @param ApplicationFinished $e
     */
    public function whenApplicationFinishes(ApplicationFinished $e)
    {
        $this->client->query()
            ->table('applications')
            ->where('id', $e->getApplicationId())
            ->update(
                [
                    'finished'    => true,
                    'finished_at' => $e->getFinishedAt(),
                ]
            );
    }

    /**
     * @param ApplicationRejected $e
     */
    public function whenApplicationRejected(ApplicationRejected $e)
    {
        $this->client->query()
            ->table('applications')
            ->where('id', $e->getApplicationId())
            ->update(
                [
                    'finished'        => false,
                    'rejected'        => true,
                    'rejected_reason' => $e->getRejectReason(),
                ]
            );
    }

    /**
     * @param ApplicationApproved $e
     */
    public function whenApplicationApproved(ApplicationApproved $e)
    {
        $this->client->query()
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

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenApplicationWasStarted'               => StartedApplication::class,
            'whenApplicationAboutInformationProvided' => ApplicantAboutInformationProvided::class,
            'whenApplicantSubmitsRentingInformation'  => ApplicantProvidedRentingInformation::class,
            'whenApplicationFinishes'                 => ApplicationFinished::class,
            'whenApplicationRejected'                 => ApplicationRejected::class,
            'whenApplicationApproved'                 => ApplicationApproved::class,
        ];
    }
}