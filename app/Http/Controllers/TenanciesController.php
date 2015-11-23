<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Requests\Tenancies\DraftTenancyHttpRequest;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Commands\DraftTenancy;
use FullRent\Core\Tenancy\Queries\FindPropertiesDraftTenancies;
use FullRent\Core\Tenancy\Queries\FindTenancyById;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class TenanciesController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenanciesController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /** @var QueryBus */
    private $queryBus;

    /**
     * TenanciesController constructor.
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param DraftTenancyHttpRequest $request
     * @return array
     */
    public function draft(DraftTenancyHttpRequest $request)
    {
        $this->commandBus->execute($command = new DraftTenancy(uuid(),
                                                               $request->get('company_id'),
                                                               $request->get('tenancy_property_id'),
                                                               $request->get('tenancy_start'),
                                                               $request->get('tenancy_end'),
                                                               $request->get('tenancy_rent_amount'),
                                                               $request->get('tenancy_rent_frequency')));

        return ['tenancy_id' => $command->getTenancyId()];
    }

    /**
     * @param $propertyId
     * @return array
     */
    public function getPropertiesDraftTenancies($propertyId)
    {
        return [
            'tenancies' => $this->queryBus->query(new FindPropertiesDraftTenancies($propertyId))
        ];
    }

    /**
     * @param $tenancyId
     * @return array
     */
    public function getTenancyById($tenancyId)
    {
        return ['tenancy' => $this->queryBus->query(new FindTenancyById($tenancyId))];
    }


}