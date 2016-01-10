<?php
namespace FullRent\Core\Application\Http\Controllers\Tenancies;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Tenancy\Commands\InviteExistingUserToTenancy;
use FullRent\Core\Tenancy\Commands\InviteNewUserToTenancy;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use Illuminate\Http\Request;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class TenanciesInviteController
 * @package FullRent\Core\Application\Http\Controllers\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenanciesInviteController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /** @var QueryBus */
    private $queryBus;

    /**
     * TenanciesInviteController constructor.
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param $tenancyId
     * @return \Illuminate\View\View
     */
    public function getInviteForm($tenancyId)
    {
        $this->authorize('manage_tenancy');

        return view('dashboard.tenancies.invite-email', ['tenancyId' => $tenancyId]);
    }

    /**
     * @param Request $request
     * @param $tenancyId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postInviteViaEmail(Request $request, $tenancyId)
    {
        $this->authorize('manage_tenancy');

        //does fullrent know who this person is?
        $user = $this->queryBus->query(new FindUserByEmailQuery($request->get('email')));

        if ($user === null) {
            $this->commandBus->execute(new InviteNewUserToTenancy($tenancyId, uuid(), $request->get('email')));
        } else {
            $this->commandBus->execute(new InviteExistingUserToTenancy($tenancyId, $user->id));
        }

        sleep(2);//damn event store

        return redirect("/tenancies/{$tenancyId}")
            ->with($this->notification('Tenant Invited',
                                       "{$request->get('email')} has been invited to join tenancy via email"));
    }
}