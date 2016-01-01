<?php
namespace FullRent\Core\Application\Http\Controllers\Tenancies\RentBook;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Requests\Tenancies\RentBook\ChangeRentBookPaymentInfoRequest;
use FullRent\Core\Tenancy\Commands\AmendScheduledTenancyRentPayment;
use FullRent\Core\Tenancy\Commands\RemoveScheduledRentPayment;
use FullRent\Core\Tenancy\Commands\ScheduleTenancyRentPayment;
use Illuminate\Http\Request;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class TenanciesRentBookController
 * @package FullRent\Core\Application\Http\Controllers\Tenancies\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenanciesRentBookController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * TenanciesRentBookController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function change()
    {
        return view('dashboard.tenancies.rentbook.change');
    }

    public function add()
    {
        return view('dashboard.tenancies.rentbook.add');
    }


    /**
     * @param Request $request
     * @param $tenancyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPayment(Request $request, $tenancyId)
    {
        $this->commandBus->execute(new ScheduleTenancyRentPayment(uuid(),
                                                                  $tenancyId,
                                                                  $request->get('rent_amount'),
                                                                  $request->get('rent_due')));
        sleep(2);

        return redirect("tenancies/{$tenancyId}#rentbook")
            ->with($this->notification('Rent Scheduled', 'Your rent payment has been scheduled.'));
    }

    /**
     * @param ChangeRentBookPaymentInfoRequest $request
     * @param $tenancyId
     * @param $rentPaymentId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateRentPayment(ChangeRentBookPaymentInfoRequest $request, $tenancyId, $rentPaymentId)
    {
        $this->commandBus->execute(new AmendScheduledTenancyRentPayment($tenancyId,
                                                                        $rentPaymentId,
                                                                        $request->get('rent_amount'),
                                                                        $request->get('rent_due')));

        sleep(2);

        return redirect("tenancies/{$tenancyId}#rentbook")
            ->with($this->notification('Rent Updated', 'Your rent payment has been updated'));
    }

    /**
     * @param $tenancyId
     * @param $rentPaymentId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteRentPayment($tenancyId, $rentPaymentId)
    {

        $this->commandBus->execute(new RemoveScheduledRentPayment($tenancyId, $rentPaymentId));

        sleep(2);

        return redirect("tenancies/{$tenancyId}#rentbook")
            ->with($this->notification('Rent Payment Deleted', 'Success the rent payment has been deleted'));
    }
}