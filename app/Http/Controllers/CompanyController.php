<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\CreateCompanyHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\RegisterCompany;
use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\Exceptions\CompanyNotFoundException;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyName;
use FullRent\Core\User\Commands\RegisterUser;
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
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var CompanyReadRepository
     */
    private $companyReadRepository;

    /**
     * @param CommandBus $bus
     * @param JsonResponse $jsonResponse
     * @param CompanyReadRepository $companyReadRepository
     */
    public function __construct(
        CommandBus $bus,
        JsonResponse $jsonResponse,
        CompanyReadRepository $companyReadRepository
    ) {
        $this->bus = $bus;
        $this->jsonResponse = $jsonResponse;
        $this->companyReadRepository = $companyReadRepository;
    }

    /**
     * @param Request $request
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
            new Name($request->get('user_legal_name'), $request->get('user_know_as', '')),
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
        try {
            $this->companyReadRepository->getByDomain(new CompanyDomain($companyDomain));

            return $this->jsonResponse->success(['exists' => true]);
        } catch (CompanyNotFoundException $ex) {
            return $this->jsonResponse->success(['exists' => false]);
        }
    }
}