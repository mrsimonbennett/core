<?php
namespace FullRent\Core\Application\Http\Controllers\ManageAccount;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Controllers\ManageAccount;
use FullRent\Core\Application\Http\Requests\UpdateUserBasicDetailsHTTPRequest;
use FullRent\Core\Application\Http\Requests\UpdateUserEmailHttpRequest;
use FullRent\Core\Application\Http\Requests\UpdateUserPasswordHttpRequest;
use FullRent\Core\User\Commands\AmendUsersName;
use FullRent\Core\User\Commands\ChangeUserPassword;
use FullRent\Core\User\Commands\ChangeUsersEmailAddress;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class ManageAccountController
 * @package FullRent\Core\Application\Http\Controllers\ManageAccount
 * @author Simon Bennett <simon@bennett.im>
 */
final class ManageAccountController extends Controller
{


    /** @var Guard */
    private $guard;

    /** @var CommandBus */
    private $commandBus;

    /**
     * @param Guard $guard
     * @param CommandBus $commandBus
     */
    public function __construct(Guard $guard, CommandBus $commandBus)
    {
        $this->guard = $guard;
        $this->commandBus = $commandBus;
    }


    /**
     * @param string $type
     * @return \Illuminate\View\View
     * @throws NotFoundHttpException
     */
    public function index($type = 'basic')
    {
        if (!in_array($type, ['basic', 'email', 'password'])) {
            throw new NotFoundHttpException;
        }

        return $this->settings($this->guard->user()->getAuthIdentifier(), $type);
    }

    /**
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function settings($id, $type)
    {
        return view('dashboard.manage-account.index', ['userId' => $id, 'settingsType' => $type]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateNameDetails(UpdateUserBasicDetailsHTTPRequest $request)
    {
        $this->commandBus->execute(new AmendUsersName($this->guard->user()->id,
                                                      $request->legal_name,
                                                      $request->known_as));

        return redirect('/manage-account')->with($this->notification('Your Name has been saved'));
    }


    /**
     * @param UpdateUserEmailHttpRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateEmail(UpdateUserEmailHttpRequest $request)
    {
        $this->commandBus->execute(new ChangeUsersEmailAddress($this->guard->user()->id, $request->email));

        return redirect('/manage-account/email')->with($this->notification('Your Email has been updated'));
    }

    /**
     * @param UpdateUserPasswordHttpRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdateUserPasswordHttpRequest $request)
    {
        $this->commandBus->execute(new ChangeUserPassword($this->guard->user()->id,
                                                          $request->get('old_password'),
                                                          $request->get('new_password')));

        return redirect('/manage-account/password')->with($this->notification('Your Password has been updated'));
    }


}