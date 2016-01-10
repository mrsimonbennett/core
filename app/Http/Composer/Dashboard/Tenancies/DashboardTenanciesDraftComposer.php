<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Tenancies;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Projections\Properties\Queries\FindPropertiesByCompany;
use FullRent\Core\QueryBus\QueryBus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class DashboardTenanciesDraftComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardTenanciesDraftComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var CompanyModal */
    private $companyModal;

    /** @var Request */
    private $request;

    /**
     * DashboardTenanciesDraftComposer constructor.
     * @param QueryBus $queryBus
     * @param CompanyModal $companyModal
     * @param Request $request
     */
    public function __construct(QueryBus $queryBus, CompanyModal $companyModal, Request $request)
    {
        $this->queryBus = $queryBus;
        $this->companyModal = $companyModal;
        $this->request = $request;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $resultProperties = $this->queryBus->query(new FindPropertiesByCompany($this->companyModal->id));
        $properties = array_map(function ($property) {
            return [$property->id => $property->address_firstline];
        },
            $resultProperties);

        $view->with('properties', $this->collapse($properties));
        $view->with('currentPropertyId', $this->request->get('propertyId'));
    }

    /**
     * Collapse the collection items into a single array.
     *
     * @param $array
     * @return static
     */
    public function collapse($array)
    {
        $results = [];

        foreach ($array as $values) {
            $results = array_merge($results, $values);
        }

        return $results;
    }

}