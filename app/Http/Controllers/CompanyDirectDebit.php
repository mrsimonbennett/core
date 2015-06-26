<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\RegisterDirectDebitService;
use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class CompanyDirectDebit
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanyDirectDebit extends Controller
{
    /**
     * @var QueryBus
     */
    private $queryBus;
    /**
     * @var DirectDebitAccountAuthorisation
     */
    private $directDebit;
    /**
     * @var JsonResponse
     */
    private $jsonResponse;
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param QueryBus $queryBus
     * @param CommandBus $commandBus
     * @param DirectDebitAccountAuthorisation $directDebit
     * @param JsonResponse $jsonResponse
     */
    public function __construct(
        QueryBus $queryBus,
        CommandBus $commandBus,
        DirectDebitAccountAuthorisation $directDebit,
        JsonResponse $jsonResponse
    ) {
        $this->queryBus = $queryBus;
        $this->directDebit = $directDebit;
        $this->jsonResponse = $jsonResponse;
        $this->commandBus = $commandBus;
    }

    public function authorizationUrl($id)
    {
        $company = $this->queryBus->query(new FindCompanyByIdQuery($id));

        return $this->jsonResponse->success(['authorize_url' => $this->directDebit->generateAuthorisationUrl("https://{$company->domain}.fullrentcore.local/direct-debit/access_token")]);
    }

    /**
     * @param $companyId
     * @param Request $request
     */
    public function accessToken($companyId, Request $request)
    {
        $this->commandBus->execute(new RegisterDirectDebitService($companyId, $request->get('code')));
    }
}