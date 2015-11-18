<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Requests\UpdateUserBasicDetailsHTTPRequest;
use FullRent\Core\Application\Http\Requests\UpdateUserEmailHttpRequest;
use FullRent\Core\Application\Http\Requests\UpdateUserPasswordHttpRequest;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\User\Commands\AmendUsersName;
use FullRent\Core\User\Commands\ChangeUserPassword;
use FullRent\Core\User\Commands\ChangeUsersEmailAddress;
use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SmoothPhp\Contracts\CommandBus\CommandBus;

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

    /** @var CommandBus */
    private $commandBus;

    /**
     * @param UserReadRepository $userRepository
     * @param MySqlClient $client
     * @param CommandBus $commandBus
     */
    public function __construct(UserReadRepository $userRepository, MySqlClient $client, CommandBus $commandBus)
    {
        $this->userRepository = $userRepository;
        $this->client = $client;
        $this->commandBus = $commandBus;
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
    public function me(Request $request)
    {
        $user = $this->userRepository->getById(new UserId('0439fdfe-1e37-4e5f-b300-312d96314180'));

        return ['user' => (array)$user, 'token' => md5(time())];

    }

    /**
     * @param Request $request
     */
    public function rememberMe(Request $request, $userId)
    {
        $this->client->query()->table('users')->where('id', $userId)->update(['remember_token' => $request->token]);
    }

    /**
     * @param $userId
     * @param UpdateUserBasicDetailsHTTPRequest $request
     */
    public function basicDetails($userId, UpdateUserBasicDetailsHTTPRequest $request)
    {
        $this->commandBus->execute(new AmendUsersName($userId, $request->legal_name, $request->known_as));
    }

    public function updateEmail($userId, UpdateUserEmailHttpRequest $request)
    {
        $this->commandBus->execute(new ChangeUsersEmailAddress($userId, $request->email));
    }

    public function updatePassword($userId, UpdateUserPasswordHttpRequest $request)
    {
        $this->commandBus->execute(new ChangeUserPassword($userId,
                                                          $request->get('old_password'),
                                                          $request->get('new_password')));
    }
}