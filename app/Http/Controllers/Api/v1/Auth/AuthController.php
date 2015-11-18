<?php
namespace FullRent\Core\Application\Http\Controllers\Api\v1\Auth;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use FullRent\Core\Application\Http\Controllers\Api\v1\ApiController;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class AuthController
 * @package FullRent\Core\Application\Http\Controllers\Api\v1\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthController extends ApiController
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Hasher */
    private $hasher;

    /**
     * AuthController constructor.
     * @param QueryBus $queryBus
     * @param Hasher $hasher
     */
    public function __construct(QueryBus $queryBus, Hasher $hasher)
    {
        $this->queryBus = $queryBus;
        $this->hasher = $hasher;
    }

    /**
     * @param Request $request
     * @return array|Response|null
     */
    public function postTokenLogin(Request $request)
    {

        $user = $this->queryBus->query(new FindUserByEmailQuery($request->get('email')));

        if ($user !== null && $this->hasher->check($request->get('password'), $user->password)) {
            $token = [
                "iss"     => "api.fullrent.co.uk",
                "iat"     => Carbon::now()->timestamp,
                "exp"     => Carbon::now()->addMinutes(10)->timestamp,
                "user_id" => $user->id,
            ];

            $jwt = JWT::encode($token, env('APP_KEY'));

            $response = new Response();
            $response->setStatusCode(201);
            $response->withCookie(new Cookie('token', $jwt,Carbon::now()->addMinutes(10)));

            return $response;
        }

        return new Response('Authentication failure', 401);
    }
}