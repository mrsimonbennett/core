<?php
namespace FullRent\Core\Application\Http\Controllers\Tenancy;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Commands\AmendScheduledTenancyRentPayment;
use FullRent\Core\Tenancy\Commands\RemoveScheduledRentPayment;
use FullRent\Core\Tenancy\Commands\ScheduleTenancyRentPayment;
use FullRent\Core\Tenancy\Queries\FindTenancyRentBookPayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class TenanciesRentBookController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenanciesRentBookController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /** @var QueryBus */
    private $queryBus;

    /**
     * TenanciesRentBookController constructor.
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param Request $request
     * @param $tenancyId
     */
    public function addPayment(Request $request, $tenancyId)
    {
        $this->commandBus->execute(new ScheduleTenancyRentPayment(uuid(),
                                                                  $tenancyId,
                                                                  $request->get('rent_amount'),
                                                                  $request->get('rent_due')));
    }

    /**
     * @param $tenancyId
     * @param $rentPaymentId
     * @return array
     */
    public function getRentPayment($tenancyId, $rentPaymentId)
    {
        return ['payment' => $this->queryBus->query(new FindTenancyRentBookPayment($rentPaymentId))];
    }

    /**
     * @param Request $request
     * @param $tenancyId
     * @param $rentPaymentId
     */
    public function updateRentPayment(Request $request, $tenancyId, $rentPaymentId)
    {
        $this->commandBus->execute(new AmendScheduledTenancyRentPayment($tenancyId,
                                                                        $rentPaymentId,
                                                                        $request->get('rent_amount'),
                                                                        $request->get('rent_due')));
    }

    /**
     * @param $tenancyId
     * @param $rentPaymentId
     */
    public function removeRentPayment($tenancyId, $rentPaymentId)
    {
        $this->commandBus->execute(new RemoveScheduledRentPayment($tenancyId, $rentPaymentId));
    }
}