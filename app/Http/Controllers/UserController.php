<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class UserController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class UserController extends Controller
{
    /**
     * @var UserReadRepository
     */
    private $userRepository;
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param UserReadRepository $userRepository
     * @param MySqlClient $client
     */
    public function __construct(UserReadRepository $userRepository, MySqlClient $client)
    {
        $this->userRepository = $userRepository;
        $this->client = $client;
    }

    /**
     * @param $userId
     * @return array|null
     */
    public function show($userId)
    {
        try {
            $user = $this->userRepository->getById(new UserId($userId));

            return (array)$user;
        } catch (UserNotFound $ex) {
            return null;
        }
    }

    /**
     * @param Request $request
     */
    public function rememberMe(Request $request, $userId)
    {
        $this->client->query()->table('users')->where('id', $userId)->update(['remember_token'=> $request->token]);
    }
}