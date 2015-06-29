<?php
namespace FullRent\Core\Infrastructure\Email;

use FullRent\Core\Application\Events\ApplicationFinished;
use FullRent\Core\Application\Events\ApplicationRejected;
use FullRent\Core\Application\Query\ApplicationReadRepository;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\Infrastructure\Events\EventListener;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class LandlordEmails
 * @package FullRent\Core\Infrastructure\Email
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationEmails extends EventListener
{

    /**
     * @var EmailClient
     */
    private $emailClient;


    /**
     * @var ApplicationReadRepository
     */
    private $applicationReadRepository;
    /**
     * @var UserReadRepository
     */
    private $userReadRepository;
    /**
     * @var PropertiesReadRepository
     */
    private $propertiesReadRepository;
    /**
     * @var CompanyReadRepository
     */
    private $companyReadRepository;

    /**
     * @param EmailClient $emailClient
     * @param ApplicationReadRepository $applicationReadRepository
     * @param UserReadRepository $userReadRepository
     * @param PropertiesReadRepository $propertiesReadRepository
     * @param CompanyReadRepository $companyReadRepository
     */
    public function __construct(
        EmailClient $emailClient,
        ApplicationReadRepository $applicationReadRepository,
        UserReadRepository $userReadRepository,
        PropertiesReadRepository $propertiesReadRepository,
        CompanyReadRepository $companyReadRepository
    ) {
        $this->emailClient = $emailClient;
        $this->applicationReadRepository = $applicationReadRepository;
        $this->userReadRepository = $userReadRepository;
        $this->propertiesReadRepository = $propertiesReadRepository;
        $this->companyReadRepository = $companyReadRepository;
    }

    /**
     * @param ApplicationFinished $applicationFinished
     */
    public function whenApplicationFinishesEmailLandlord(ApplicationFinished $applicationFinished)
    {
        list($application, $applicant, $property, $landlord, $company) = $this->getApplicationDetails($applicationFinished);

        $this->emailClient->send('applications.finished-landlord',
                                 "Application for {$property->address_firstline} by {$applicant->known_as} has been completed for your review",
                                 [
                                     'application' => $application,
                                     'applicant'   => $applicant,
                                     'landlord'    => $landlord,
                                     'property'    => $property,
                                     'company'     => $company,
                                 ],
                                 $landlord->known_as,
                                 $landlord->email);


    }

    /**
     * @param ApplicationRejected $applicationRejected
     */
    public function whenApplicationWasRejected(ApplicationRejected $applicationRejected)
    {
        list($application, $applicant, $property, $landlord, $company) = $this->getApplicationDetails($applicationRejected);

        $this->emailClient->send('applications.rejected',
                                 "Sorry your Application for {$property->address_firstline} has been rejected but can be fixed",
                                 [
                                     'application' => $application,
                                     'applicant'   => $applicant,
                                     'landlord'    => $landlord,
                                     'property'    => $property,
                                     'company'     => $company,
                                     'reason'      => $applicationRejected->getRejectReason()->getReason(),
                                 ],
                                 $applicant->known_as,
                                 $applicant->email);
    }

    /**
     * @param ApplicationFinished $applicationFinished
     * @return array
     */
    protected function getApplicationDetails($applicationFinished)
    {
        $application = $this->applicationReadRepository->getById($applicationFinished->getApplicationId());
        $applicant = $this->userReadRepository->getById(new UserId($application->applicant_id));
        $property = $this->propertiesReadRepository->getById(new PropertyId($application->property_id));
        $landlord = $this->userReadRepository->getById(new UserId($property->landlord_id));
        $company = $this->companyReadRepository->getById(new CompanyId($property->company_id));

        return array($application, $applicant, $property, $landlord, $company);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function registerOnce()
    {
        return [
            'whenApplicationFinishesEmailLandlord' => ApplicationFinished::class,
            'whenApplicationWasRejected' => ApplicationRejected::class,
        ];
    }
}