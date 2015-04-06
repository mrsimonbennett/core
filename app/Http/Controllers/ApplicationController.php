<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Commands\StartApplication;
use FullRent\Core\Application\Commands\SubmitAboutInformation;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\CreateApplicationAccountHttpRequest;
use FullRent\Core\Application\Http\Requests\SubmitAboutInformationHttpRequest;
use FullRent\Core\Application\ValueObjects\AboutYouApplication;
use FullRent\Core\Application\ValueObjects\AboutYouDescription;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\DateOfBirth;
use FullRent\Core\Application\ValueObjects\PhoneNumber;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\User\Commands\RegisterUser;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
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
     * @param CommandBus $commandBus
     * @param JsonResponse $jsonResponse
     */
    public function __construct(CommandBus $commandBus, JsonResponse $jsonResponse)
    {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
    }

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
                                                'user_id'     => (string)$createUser->getUserId(),
                                                'application_id' => (string)$createApplication->getApplicationId()
                                            ]);
    }

    /**
     * @param SubmitAboutInformationHttpRequest $request
     * @param $propertyId
     * @param $applicationId
     */
    public function personal(SubmitAboutInformationHttpRequest $request, $propertyId, $applicationId)
    {
        $aboutInformation = new AboutYouApplication(new AboutYouDescription($request->about),new DateOfBirth($request->dob),new PhoneNumber($request->phone));


        $this->commandBus->execute(new SubmitAboutInformation(new ApplicationId($applicationId),$aboutInformation));
    }
}