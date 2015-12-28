<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Requests\Auth\AuthLoginHttpRequest;
use Illuminate\Contracts\Auth\Guard;
use Lang;

/**
 * Class AuthLoginController
 * @package FullRent\Core\Application\Http\Controllers\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthLoginController extends Controller
{
    /** @var Guard */
    private $guard;

    /**
     * AuthLoginController constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * @param AuthLoginHttpRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(AuthLoginHttpRequest $request)
    {
        if ($this->guard->attempt($request->only(['email', 'password']))) {
            return redirect()->intended("/");
        }

        return redirect("/auth/login")
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                             'email' => $this->getFailedLoginMessage(),
                         ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    private function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? Lang::get('auth.failed')
            : 'These credentials do not match our records.';
    }

}