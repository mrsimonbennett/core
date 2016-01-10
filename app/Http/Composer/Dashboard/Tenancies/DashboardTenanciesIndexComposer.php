<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Tenancies;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Queries\FindTenancyByCompanyId;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardTenanciesIndexComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardTenanciesIndexComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var CompanyModal */
    private $companyModal;

    /**
     * DashboardTenanciesIndexComposer constructor.
     * @param QueryBus $queryBus
     * @param CompanyModal $companyModal
     */
    public function __construct(QueryBus $queryBus, CompanyModal $companyModal)
    {
        $this->queryBus = $queryBus;
        $this->companyModal = $companyModal;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('tenancies', $this->queryBus->query(new FindTenancyByCompanyId($this->companyModal->id)));
    }
}