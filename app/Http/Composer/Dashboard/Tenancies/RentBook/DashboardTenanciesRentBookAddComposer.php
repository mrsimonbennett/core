<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook;

use FullRent\Core\Application\Http\Composer\Composer;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Router;

/**
 * Class DashboardTenanciesRentBookAddComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Tenancies\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardTenanciesRentBookAddComposer implements Composer
{

    /** @var Router */
    private $router;

    /**
     * DashboardTenanciesRentBookChangeComposer constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('tenancyId', $this->router->current()->parameter('tenancyId'));
    }
}