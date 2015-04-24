<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Contract\Query\ContractReadRepository;
use FullRent\Core\Contract\ValueObjects\PropertyId;
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
     * @param CommandBus $bus
     * @param ContractReadRepository $contractReadRepository
     * @param JsonResponse $jsonResponse
     */
    public function __construct(
        CommandBus $bus,
        ContractReadRepository $contractReadRepository,
        JsonResponse $jsonResponse
    ) {
        $this->bus = $bus;
        $this->contractReadRepository = $contractReadRepository;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @param $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function  index($propertyId)
    {
        return $this->jsonResponse->success(['contracts' => $this->contractReadRepository->getByProperty(new PropertyId($propertyId))]);
    }
}