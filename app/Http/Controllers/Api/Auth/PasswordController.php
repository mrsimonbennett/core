<?php
namespace FullRent\Core\Application\Http\Controllers\Api\Auth;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\ResetPasswordHttpRequest;
use FullRent\Core\Application\Http\Requests\ResetPasswordWithNewHttpRequest;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use FullRent\Core\User\Commands\ResetUsersPassword;
use FullRent\Core\User\Commands\ResetUsersPasswordRequest;
use Illuminate\Routing\Controller;

/**
 * Class PasswordController
 * @package FullRent\Core\Application\Http\Controllers\Api\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class PasswordController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /** @var JsonResponse */
    private $jsonResponse;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus, JsonResponse $jsonResponse)
    {
        $this->commandBus = $commandBus;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @param ResetPasswordHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function email(ResetPasswordHttpRequest $request)
    {
        $this->commandBus->execute(new ResetUsersPasswordRequest($request->get('email')));

        return $this->jsonResponse->success();
    }

    /**
     * @param $token
     * @param ResetPasswordWithNewHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset($token, ResetPasswordWithNewHttpRequest $request)
    {
        $this->commandBus->execute(new ResetUsersPassword($request->get('email'), $request->get('password'), $token));

        return $this->jsonResponse->success();

    }

}