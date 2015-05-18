<?php
namespace FullRent\Core\Application\Http\Controllers\Tenant;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Contract\ValueObjects\TenantId;
use Illuminate\Routing\Controller;

/**
 * Class ContractsController
 * @package FullRent\Core\Application\Http\Controllers\Tenant
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractsController extends Controller
{
    /**
     * @var ContractReadRepository
     */
    private $contractReadRepository;
    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    /**
     * @param ContractReadRepository $contractReadRepository
     * @param JsonResponse $jsonResponse
     */
    public function __construct(ContractReadRepository $contractReadRepository, JsonResponse $jsonResponse)
    {
        $this->contractReadRepository = $contractReadRepository;
        $this->jsonResponse = $jsonResponse;
    }

    public function getTenantsContracts($tenantId)
    {
        return $this->jsonResponse->success(['contracts' => $this->contractReadRepository->getByTenantId(new TenantId($tenantId))]);
    }
}