<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook;

use FullRent\Core\Application\Http\Composer\Composer;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Queries\FindTenancyRentBookPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

/**
 * Class DashboardTenanciesRentBookChangeComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardTenanciesRentBookChangeComposer implements Composer
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Router */
    private $router;

    /**
     * DashboardTenanciesRentBookChangeComposer constructor.
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
        $rentPaymentId = $this->router->current()->parameter('rentPaymentId');

        $rentPayment = $this->queryBus->query(new FindTenancyRentBookPayment($rentPaymentId));

        $view->with(
            [
                'tenancyId'     => $tenancyId,
                'rentPaymentId' => $rentPaymentId,
                'rentPayment'   => $rentPayment
            ]);
    }
}