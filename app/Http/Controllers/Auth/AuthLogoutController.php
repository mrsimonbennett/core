<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\Application\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class AuthLogoutController
 * @package FullRent\Core\Application\Http\Controllers\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthLogoutController extends Controller
{
    /** @var Guard */
    private $guard;

    /**
     * AuthLogoutController constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        $this->guard->logout();

        return redirect('/auth/login')->withSuccess('You have been logged out');;
    }
}