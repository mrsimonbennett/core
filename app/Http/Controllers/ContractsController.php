<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\SaveContractDatesHttpRequest;
use FullRent\Core\Application\Http\Requests\SaveContractDocumentHttpRequest;
use FullRent\Core\Application\Http\Requests\SaveContractRentHttpRequest;
use FullRent\Core\Application\Http\Requests\TenantDirectDebitAccessTokenHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Queries\FindCompanyByIdQuery;
use FullRent\Core\Contract\Commands\LandlordSignContract;
use FullRent\Core\Contract\Commands\LockContract;
use FullRent\Core\Contract\Commands\SetContractPeriod;
use FullRent\Core\Contract\Commands\SetContractRentInformation;
use FullRent\Core\Contract\Commands\SetContractsRequiredDocuments;
use FullRent\Core\Contract\Commands\TenantSignContract;
use FullRent\Core\Contract\Commands\TenantUploadEarningsDocument;
use FullRent\Core\Contract\Commands\TenantUploadId;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Contract\Query\FindContractByIdQuery;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Deposit\Commands\PayDepositWithCard;
use FullRent\Core\Deposit\Queries\FindAllDepositInformationForContractQuery;
use FullRent\Core\Deposit\Queries\FindTenantsDepositQuery;
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
     * @param $contractId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($contractId)
    {
        return $this->jsonResponse->success(['contract' => $this->queryBus->query(new FindContractByIdQuery($contractId))]);
    }

    /**
     * @param $contractId
     * @param SaveContractDatesHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDates($contractId, SaveContractDatesHttpRequest $request)
    {
        $this->bus->execute(new SetContractPeriod($contractId, $request->start, $request->end));

        return $this->jsonResponse->success();
    }

    /**
     * @param $contractId
     * @param SaveContractRentHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRent($contractId, SaveContractRentHttpRequest $request)
    {
        $this->bus->execute(new SetContractRentInformation($contractId,
                                                           $request->rent,
                                                           $request->rent_payable,
                                                           $request->first_rent,
                                                           $request->has('fullrent_rent_collection'),
                                                           $request->deposit,
                                                           $request->deposit_due,
                                                           $request->fullrent_deposit));

        return $this->jsonResponse->success();
    }

    /**
     * @param $contractId
     * @param SaveContractDocumentHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDocuments($contractId, SaveContractDocumentHttpRequest $request)
    {
        $this->bus->execute(new SetContractsRequiredDocuments($contractId,
                                                              $request->has('require_id'),
                                                              $request->has('require_earnings_proof'),
                                                              $request->get('additional_documents')));

        return $this->jsonResponse->success();
    }

    /**
     * @param $contractId
     * @return \Illuminate\Http\JsonResponse
     */
    public function lockContract($contractId)
    {
        $this->bus->execute(new LockContract($contractId));

        return $this->jsonResponse->success();
    }

    /**
     * @param Request $request
     * @param $contractId
     * @return \Illuminate\Http\JsonResponse
     */
    public function landlordSignContract(Request $request, $contractId)
    {
        $this->bus->execute(new LandlordSignContract($contractId, $request->get('signature')));

        return $this->jsonResponse->success();
    }

    /**
     * @param Request $request
     * @param $contractId
     */
    public function tenantUploadIdDocument(Request $request, $contractId)
    {
        $this->bus->execute(new TenantUploadId($contractId, $request->get('tenant_id'), $request->file('id')));
    }

    /**
     * @param Request $request
     * @param $contractId
     */
    public function tenantUploadEarningsDocument(Request $request, $contractId)
    {
        $this->bus->execute(new TenantUploadEarningsDocument($contractId,
                                                             $request->get('tenant_id'),
                                                             $request->file('earnings')));
    }

    /**
     * @param Request $request
     * @param $contractId
     */
    public function tenantSignContract(Request $request, $contractId)
    {
        $this->bus->execute(new TenantSignContract($contractId,
                                                   $request->get('tenant_id'),
                                                   $request->get('signature')));
    }

    public function getDepositInformation($contractId)
    {
        return $this->jsonResponse->success(['deposits' => $this->queryBus->query(new FindAllDepositInformationForContractQuery($contractId))]);
    }

    public function getDepositInformationForTenant($contractId, $tenantId)
    {
        return $this->jsonResponse->success([
                                                'deposit' => $this->queryBus->query(new FindTenantsDepositQuery($contractId,
                                                                                                                $tenantId))
                                            ]);

    }

    public function tenantPayDeposit($contractId, Request $request)
    {
        $deposit = $this->queryBus->query(new FindTenantsDepositQuery($contractId, $request->get('tenant_id')));

        $this->bus->execute(new PayDepositWithCard($deposit->id,
                                                   $request->get('name'),
                                                   $request->get('number'),
                                                   $request->get('expiry'),
                                                   $request->get('cvc')));
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


        return [
            'authorization_url' => $debit->generatePreAuthorisationUrl($contract->rent*4,
                                                                       new DirectDebitUser(),
                                                                       "https://{$company->domain}.fullrentcore.local/contracts/{$contractId}/tenant/access_token",
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