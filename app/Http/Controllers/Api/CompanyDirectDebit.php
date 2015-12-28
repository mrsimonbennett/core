<?php
namespace FullRent\Core\Application\Http\Controllers\Api;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Company\Commands\RegisterDirectDebitService;
use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class CompanyDirectDebit
 * @package FullRent\Core\Application\Http\Controllers\Api
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

    /**
     * @param string $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorizationUrl($id, Request $request)
    {
        $company = $this->queryBus->query(new FindCompanyByIdQuery($id));
        $hostDomain = env('CARDLESS_REDIRECT');

        //Store Billing Address


        return $this->jsonResponse->success(
            [
                'authorize_url' => $this->directDebit->generateAuthorisationUrl("https://{$company->domain}.{$hostDomain}/{$request->get('redirect_path')}",
                                                                                [
                                                                                    'phone_number' => $request->get('phone'),
                                                                                    'user'         => [
                                                                                        'billing_address1' => $request->get('address')
                                                                                    ],
                                                                                ]),
            ]);
    }

    /**
     * @param $companyId
     * @param Request $request
     */
    public function accessToken($companyId, Request $request)
    {
        $this->commandBus->execute(new RegisterDirectDebitService($companyId, $request->get('code'), $request->get('redirect_path')));
    }
}