<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\CreateCompanyHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\EnrolTenant;
use FullRent\Core\Company\Commands\RegisterCompany;
use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Commands\InviteUser;
use FullRent\Core\User\Commands\RegisterUser;
use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class CompanyController
 * @package app\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyController extends Controller
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    /**
     * @var CompanyReadRepository
     */
    private $companyReadRepository;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param CommandBus $bus
     * @param JsonResponse $jsonResponse
     * @param CompanyReadRepository $companyReadRepository
     * @param QueryBus $queryBus
     */
    public function __construct(
        CommandBus $bus,
        JsonResponse $jsonResponse,
        CompanyReadRepository $companyReadRepository,
        QueryBus $queryBus
    ) {
        $this->bus = $bus;
        $this->jsonResponse = $jsonResponse;
        $this->companyReadRepository = $companyReadRepository;
        $this->queryBus = $queryBus;
    }

    /**
     * @param CreateCompanyHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCompany(CreateCompanyHttpRequest $request)
    {
        $registerCompanyCommand = new RegisterCompany(
            new CompanyName($request->get('company_name')),
            new CompanyDomain($request->get('company_domain'))
        );

        $this->bus->execute($registerCompanyCommand);

        $registerUserCommand = new RegisterUser(
            UserId::fromIdentity($registerCompanyCommand->getLandlordId()),
            new Name($request->get('user_legal_name'), $request->get('user_know_as', $request->get('user_legal_name'))),
            new Email($request->get('user_email')),
            new Password(bcrypt($request->get('user_password')))
        );
        $this->bus->execute($registerUserCommand);

        return $this->jsonResponse->success([
                                                'company_id' => (string)$registerCompanyCommand->getCompanyId(),
                                                'user_id'    => (string)$registerUserCommand->getUserId()
                                            ]);
    }

    /**
     *
     */
    public function show($companyDomain)
    {
        try {
            $company = $this->companyReadRepository->getByDomain(new CompanyDomain($companyDomain));

            return $this->jsonResponse->success(['company' => (array)$company]);
        } catch (CompanyNotFoundException $ex) {
            return $this->jsonResponse->notFound(['exists' => false]);
        }
    }

    /**
     * @param $companyDomain
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkExists($companyDomain)
    {
        return $this->jsonResponse->success(['exists' => $this->companyReadRepository->doesDomainExist(new CompanyDomain($companyDomain))]);
    }

    /**
     * Invite a user ot fullrent system. If they exist we just enrol them otherwise we create them an account
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request)
    {
        try {
            $userId = $this->queryBus->query(new FindUserByEmailQuery($request->get('email')))->id;
            $this->bus->execute(new EnrolTenant($request->get('company_id'), $userId));

        } catch (UserNotFound $ex) {
            $userId = uuid();
            $this->bus->execute(new EnrolTenant($request->get('company_id'), $userId));
            $this->bus->execute(new InviteUser($userId, $request->get('email')));
        }

        return $this->jsonResponse->success(['user_id' => (string)$userId]);
    }
}