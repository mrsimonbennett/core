<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Commands\FinishApplication;
use FullRent\Core\Application\Commands\StartApplication;
use FullRent\Core\Application\Commands\SubmitAboutInformation;
use FullRent\Core\Application\Commands\SubmitRentingInformation;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\CreateApplicationAccountHttpRequest;
use FullRent\Core\Application\Http\Requests\SubmitAboutInformationHttpRequest;
use FullRent\Core\Application\Http\Requests\SubmitRentingInformationHttpRequest;
use FullRent\Core\Application\Query\ApplicationReadRepository;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\AboutYouDescription;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\DateOfBirth;
use FullRent\Core\Application\ValueObjects\PhoneNumber;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\Application\ValueObjects\RentingInformation;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\User\Commands\RegisterUser;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class ApplicationController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var JsonResponse
     */
    private $jsonResponse;
    /**
     * @var ApplicationReadRepository
     */
    private $applicationReadRepository;

    /**
     * @param CommandBus $commandBus
     * @param JsonResponse $jsonResponse
     * @param ApplicationReadRepository $applicationReadRepository
     */
    public function __construct(
        CommandBus $commandBus,
        JsonResponse $jsonResponse,
        ApplicationReadRepository $applicationReadRepository
    ) {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
        $this->applicationReadRepository = $applicationReadRepository;
    }

    /**
     * @param CreateApplicationAccountHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAccount(CreateApplicationAccountHttpRequest $request)
    {
        $createUser = new RegisterUser(UserId::random(),
                                       new Name($request->get('user_legal_name'), $request->get('user_know_as')),
                                       new Email($request->get('user_email')),
                                       new Password(bcrypt($request->get('user_password'))));

        $this->commandBus->execute($createUser);

        $createApplication = new StartApplication(ApplicantId::fromIdentity($createUser->getUserId()),
                                                  new PropertyId($request->get('property_id')));

        $this->commandBus->execute($createApplication);


        return $this->jsonResponse->success([
                                                'user_id'        => (string)$createUser->getUserId(),
                                                'application_id' => (string)$createApplication->getApplicationId()
                                            ]);
    }

    /**
     * @param SubmitAboutInformationHttpRequest $request
     * @param $propertyId
     * @param $applicationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function personal(SubmitAboutInformationHttpRequest $request, $propertyId, $applicationId)
    {
        $aboutInformation = new AboutYouApplication(new AboutYouDescription($request->about_description),
                                                    new DateOfBirth($request->date_of_birth),
                                                    new PhoneNumber($request->phone_number));


        $this->commandBus->execute(new SubmitAboutInformation(new ApplicationId($applicationId), $aboutInformation));

        return $this->jsonResponse->success();
    }

    /**
     * @param SubmitRentingInformationHttpRequest $request
     * @param $propertyId
     * @param $applicationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function residential(SubmitRentingInformationHttpRequest $request, $propertyId, $applicationId)
    {
        $command = new SubmitRentingInformation(new ApplicationId($applicationId),new RentingInformation((bool)$request->currently_renting));
        $this->commandBus->execute($command);

        return $this->jsonResponse->success();
    }

    public function finish($propertyId, $applicationId)
    {
        $this->commandBus->execute(new FinishApplication(new ApplicationId($applicationId)));
        return $this->jsonResponse->success();

    }

    /**
     * If the user does not already have a application we will just make one.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forUser(Request $request)
    {
        $application = $this->applicationReadRepository
            ->getForApplicant(new ApplicantId($request->get('user_id')),
                              new PropertyId($request->get('property_id')));
        if (!is_null($application)) {
            return $this->jsonResponse->success(
                [
                    'application_id' => $application->id
                ]
            );
        } else {
            $createApplication = new StartApplication(new ApplicantId($request->get('user_id')),
                                                      new PropertyId($request->get('property_id')));
            $this->commandBus->execute($createApplication);

            return $this->jsonResponse->success([
                                                    'application_id' => (string)$createApplication->getApplicationId()
                                                ]);
        }
    }

    public function forProperty($propertyId)
    {
        return $this->jsonResponse->success([
                                                'applications' => $this->applicationReadRepository->finishedByProperty(new PropertyId($propertyId))
                                            ]);
    }
    /**
     * @param $applicationId
     * @return \Illuminate\Http\JsonResponse
     */
    public function showApplication($propertyId,$applicationId)
    {
        return $this->jsonResponse->success(
            [
                'application' => $this->applicationReadRepository->getById(new ApplicationId($applicationId))
            ]);
    }
}