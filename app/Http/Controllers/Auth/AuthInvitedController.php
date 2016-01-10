<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\User\Commands\CompletedApplication;
use Illuminate\Http\Request;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class AuthInvitedController
 * @package FullRent\Core\Application\Http\Controllers\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthInvitedController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * AuthInvitedController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    /**
     * @param $token
     * @return \Illuminate\View\View
     */
    public function getInvitedForm($token)
    {
        return view('auth.invited', ['token' => $token]);
    }

    /**
     * @param $token
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postInvitedForm($token, Request $request)
    {
        $completedApplicationCommand = new CompletedApplication($token,
                                                                $request->get('email'),
                                                                $request->get('password'),
                                                                $request->get('legal_name'),
                                                                $request->get('known_as'));

        $this->commandBus->execute($completedApplicationCommand);

        return redirect('auth/login');
    }
}