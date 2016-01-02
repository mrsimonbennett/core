<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Requests\ResetPasswordHttpRequest;
use FullRent\Core\Application\Http\Requests\ResetPasswordWithNewHttpRequest;
use FullRent\Core\User\Commands\ResetUsersPassword;
use FullRent\Core\User\Commands\ResetUsersPasswordRequest;
use FullRent\Core\User\Exceptions\InvalidPasswordResetRequest;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class AuthPasswordController
 * @package FullRent\Core\Application\Http\Controllers\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthPasswordController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * Present the user with the password reset form
     * @return \Illuminate\View\View
     */
    public function getResetPasswordForm()
    {
        return view('auth.password.remind');
    }

    /**
     * @param $token
     * @return \Illuminate\View\View
     */
    public function getResetWithTokenForm($token)
    {
        return view('auth.password.reset', ['token' => $token]);
    }

    /**
     * @param ResetPasswordHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postResetPassword(ResetPasswordHttpRequest $request)
    {
        $this->commandBus->execute(new ResetUsersPasswordRequest($request->get('email')));

        return redirect()->back()->withSuccess('Email instructions have been sent');
    }

    /**
     * @param $token
     * @param ResetPasswordWithNewHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postResetWithTokenForm($token, ResetPasswordWithNewHttpRequest $request)
    {
        try{
            $this->commandBus->execute(new ResetUsersPassword($request->get('email'), $request->get('password'), $token));
            return redirect()->to('auth/login')->withSuccess('Password has been updated, you can now login with your new password');

        }catch(InvalidPasswordResetRequest $ex){
            return redirect()->back()->withErrors(['Password Reset Token not valid']);

        }


    }
}