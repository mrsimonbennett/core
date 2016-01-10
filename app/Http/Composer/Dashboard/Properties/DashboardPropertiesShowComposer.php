<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Properties;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyInterface;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Projections\PropertyHistory\Queries\FindPropertyHistory;
use FullRent\Core\Property\Queries\FindPropertyById;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Queries\FindPropertiesDraftTenancies;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

/**
 * Class DashboardPropertiesShowComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardPropertiesShowComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Router */
    private $router;

    /** @var CompanyInterface */
    private $companyInterface;

    /**
     * DashboardPropertiesShowComposer constructor.
     * @param QueryBus $queryBus
     * @param Router $router
     * @param CompanyInterface $companyInterface
     */
    public function __construct(QueryBus $queryBus, Router $router, CompanyModal $companyInterface)
    {
        $this->queryBus = $queryBus;
        $this->router = $router;
        $this->companyInterface = $companyInterface;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $propertyId = $this->router->current()->parameter('propertyId');

        $view->with('property', $this->queryBus->query(new FindPropertyById($propertyId)));
        $view->with('tenancies', $this->queryBus->query(new FindPropertiesDraftTenancies($propertyId)));
        $view->with('propertyHistory',$this->queryBus->query(new FindPropertyHistory($propertyId)));
    }
}