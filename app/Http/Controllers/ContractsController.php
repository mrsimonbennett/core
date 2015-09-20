<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\CreateNewContractHttpRequest;
use FullRent\Core\Application\Http\Requests\TenantDirectDebitAccessTokenHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Contract\Commands\DraftNewContract;
use FullRent\Core\Contract\Commands\JoinTenantToContract;
use FullRent\Core\Contract\Commands\LandlordSignContract;
use FullRent\Core\Contract\Commands\SetContractPeriod;
use FullRent\Core\Contract\Commands\SetContractRentInformation;
use FullRent\Core\Contract\Commands\SetContractsRequiredDocuments;
use FullRent\Core\Contract\Commands\TenantSignContract;
use FullRent\Core\Contract\Commands\TenantUploadEarningsDocument;
use FullRent\Core\Contract\Commands\TenantUploadId;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Contract\Query\FindContractByIdQuery;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Commands\RentBookAuthorizeDirectDebit;
use FullRent\Core\RentBook\Queries\FindRentBookQuery;
use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\Services\DirectDebit\DirectDebitUser;
use FullRent\Core\Services\DirectDebit\GoCardLess\GoCardLessAccessTokens;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class ContractsController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractsController extends Controller
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var ContractReadRepository
     */
    private $contractReadRepository;

    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param CommandBus $bus
     * @param ContractReadRepository $contractReadRepository
     * @param JsonResponse $jsonResponse
     * @param QueryBus $queryBus
     */
    public function __construct(
        CommandBus $bus,
        ContractReadRepository $contractReadRepository,
        JsonResponse $jsonResponse,
        QueryBus $queryBus
    ) {
        $this->bus = $bus;
        $this->contractReadRepository = $contractReadRepository;
        $this->jsonResponse = $jsonResponse;
        $this->queryBus = $queryBus;
    }

    /**
     * @param $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function  index($propertyId)
    {
        return $this->jsonResponse->success(['contracts' => $this->contractReadRepository->getByProperty(new PropertyId($propertyId))]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  indexAll(Request $request)
    {
        return $this->jsonResponse->success(['contracts' => $this->contractReadRepository->getByCompany($request->get('company_id'))]);
    }

    /**
     * @param $contractId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($contractId)
    {
        return $this->jsonResponse->success(['contract' => $this->queryBus->query(new FindContractByIdQuery($contractId))]);
    }

    /**
     * @param CreateNewContractHttpRequest $request
     */
    public function store(CreateNewContractHttpRequest $request)
    {
        $contractId = uuid();

        $this->bus->execute(new DraftNewContract($contractId,
                                                 $request->get('property_id'),
                                                 $request->get('company_id'),
                                                 $request->get('landlord_id'),
                                                 $request->start,
                                                 $request->end,
                                                 $request->get('rent'),
                                                 $request->get('first_payment_due'),
                                                 $request->get('rent_payable'),
                                                 $request->get('fullrent_rent_collection')));

        $this->bus->execute(new JoinTenantToContract($contractId, $request->get('tenant_id')));

        return $this->jsonResponse->success(['id' => $contractId]);
    }


    /**
     * @param $contractId
     * @param Request $request
     * @param DirectDebit $debit
     * @return array
     */
    public function tenantAuthorizationUrl($contractId, Request $request, DirectDebit $debit)
    {
        $contract = $this->queryBus->query(new FindContractByIdQuery($contractId));
        $company = $this->queryBus->query(new FindCompanyByIdQuery($contract->company_id));

        $domain = env('CARDLESS_REDIRECT');
        return [
            'authorization_url' => $debit->generatePreAuthorisationUrl($contract->rent * 4,
                                                                       new DirectDebitUser(),
                                                                       "https://{$company->domain}.{$domain}/contracts/{$contractId}/tenant/access_token",
                                                                       new GoCardLessAccessTokens($company->gocardless_merchant,
                                                                                                  $company->gocardless_token),
                                                                       1,
                                                                       'month',
                                                                       12)
        ];
    }

    public function tenantDirectDebitAccessToken($contractId, TenantDirectDebitAccessTokenHttpRequest $request)
    {
        $rentBook = $this->queryBus->query(new FindRentBookQuery($contractId, $request->get('tenant_id')));
        $contract = $this->queryBus->query(new FindContractByIdQuery($contractId));
        $company = $this->queryBus->query(new FindCompanyByIdQuery($contract->company_id));


        $this->bus->execute(new RentBookAuthorizeDirectDebit($rentBook->id,
                                                             $request->get('resource_id'),
                                                             $request->get('resource_type'),
                                                             $request->get('resource_uri'),
                                                             $request->get('signature'),
                                                             new GoCardLessAccessTokens($company->gocardless_merchant,
                                                                                        $company->gocardless_token)));

    }
}