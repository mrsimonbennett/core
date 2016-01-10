<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Tenancies;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Queries\FindTenancyById;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

/**
 * Class DashboardTenanciesShowComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardTenanciesShowComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Router */
    private $router;

    /**
     * DashboardTenanciesShowComposer constructor.
     * @param QueryBus $queryBus
     * @param Router $router
     */
    public function __construct(QueryBus $queryBus, Router $router)
    {
        $this->queryBus = $queryBus;
        $this->router = $router;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $tenancyId = $this->router->current()->parameter('tenancyId');

        $tenancy = $this->queryBus->query(new FindTenancyById($tenancyId));

        $rentTotal = array_reduce($tenancy->rent_book_payments,
            function ($carry, $payment) {
                return $carry + $payment->payment_amount;
            },
                                  0);

        $view->with('tenancy', $tenancy)
             ->with('rentTotal', $rentTotal);
    }
}