<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Properties;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Property\Queries\FindPropertyById;
use FullRent\Core\QueryBus\QueryBus;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

/**
 * Class DashboardPropertiesEditComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardPropertiesEditComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Router */
    private $router;

    /** @var CompanyModal */
    private $companyInterface;

    /**
     * DashboardPropertiesShowComposer constructor.
     * @param QueryBus $queryBus
     * @param Router $router
     * @param CompanyModal $companyInterface
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

        $property = $this->queryBus->query(new FindPropertyById($propertyId));

        for ($i = 1; $i < 15; $i++) {
            $bedroomOptions[$i / 2 . ""] = $i / 2;
        }
        for ($i = 1; $i < 10; $i++) {
            $bathrooms[$i / 2 . ""] = $i / 2;
        }
        $view->with('property', $property)
             ->with('title', 'Update ' . $property->address_firstline)
             ->with('bedrooms', $bedroomOptions)
             ->with('bathrooms', $bathrooms);
    }
}