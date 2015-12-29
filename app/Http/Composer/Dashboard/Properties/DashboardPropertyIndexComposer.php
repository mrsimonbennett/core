<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Properties;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Projections\Properties\Queries\FindPropertiesByCompany;
use FullRent\Core\QueryBus\QueryBus;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardPropertyIndexComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardPropertyIndexComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var CompanyModal */
    private $company;

    /**
     * DashboardPropertyIndexComposer constructor.
     * @param QueryBus $queryBus
     * @param CompanyModal $company
     */
    public function __construct(QueryBus $queryBus, CompanyModal $company)
    {
        $this->queryBus = $queryBus;
        $this->company = $company;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('properties', $this->queryBus->query(new FindPropertiesByCompany($this->company->id)));
    }
}