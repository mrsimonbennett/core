<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\RegisterCompany;
use FullRent\Core\Company\CompanyRepository;
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
     * @param CommandBus $bus
     * @param JsonResponse $jsonResponse
     */
    public function __construct(CommandBus $bus, JsonResponse $jsonResponse, CompanyRepository $companyRepository)
    {
        $this->bus = $bus;
        $this->jsonResponse = $jsonResponse;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Request $request
     */
    public function createCompany(Request $request)
    {
        $registerCompanyCommand = new RegisterCompany(
            new CompanyName($request->get('company_name')),
            new CompanyDomain($request->get('company_domain'))
        );

        $this->bus->execute($registerCompanyCommand);

        $registerUserCommand = new RegisterUser(
            UserId::fromIdentity($registerCompanyCommand->getLandlordId()),
            new Name($request->get('user_legal_name'), $request->get('user_know_as')),
            new Email($request->get('user_email')),
            new Password(bcrypt($request->get('user_password')))
        );
        $this->bus->execute($registerUserCommand);

        return $this->jsonResponse->success([
            'company_id' => (string)$registerCompanyCommand->getCompanyId(),
            'user_id' => (string)$registerUserCommand->getUserId()
        ]);
    }
    public function show()
    {
        dd($this->companyRepository->load('1c84ed6c-a09f-4d3f-b56d-7f5154eede90'));
    }
}