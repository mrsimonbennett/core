<?php
namespace FullRent\Core\Application\Http\Controllers\Api\v1;

use Firebase\JWT\JWT;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserById;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UserController
 * @package FullRent\Core\Application\Http\Controllers\Api\v1
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserController extends ApiController
{
    /** @var Guard */
    private $guard;

    /** @var QueryBus */
    private $queryBus;

    /**
     * UserController constructor.
     * @param Guard $guard
     * @param QueryBus $queryBus
     */
    public function __construct(Guard $guard, QueryBus $queryBus)
    {
        $this->guard = $guard;
        $this->queryBus = $queryBus;
    }
    public function getMe(Request $request)
    {
        try{
            JWT::$leeway = 60; // $leeway in seconds

            $decoded = JWT::decode($request->cookie('token'), env('APP_KEY'), array('HS256'));

            $this->guard->loginUsingId($decoded->user_id);

            return ['user' =>(array)$this->queryBus->query(new FindUserById($decoded->user_id))];
        }catch(\UnexpectedValueException $ex){
            return new Response('Authentication failure', 401);

        }



    }
}