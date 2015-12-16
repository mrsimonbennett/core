<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\Projections\AuthProjection\Queries\FindAuthByEmailQuery;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Commands\CompletedApplication;
use FullRent\Core\User\Exceptions\UserNotFound;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\Email;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class AuthController
 * @package FullRent\Core\Application\Http\Controllers\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthController extends Controller
{
    /**
     * @var UserReadRepository
     */
    private $userRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /** @var CommandBus */
    private $commandBus;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param UserReadRepository $userRepository
     * @param Hasher $hasher
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(
        UserReadRepository $userRepository,
        Hasher $hasher,
        CommandBus $commandBus,
        QueryBus $queryBus
    ) {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param Request $request
     * @return array|null
     */
    public function postLogin(Request $request)
    {
        try {
            $user = $this->userRepository->getByEmail(new Email($request->get('email')));

            $auth = $this->queryBus->query(new FindAuthByEmailQuery($request->get('email')));

            if ($this->hasher->check($request->get('password'), $auth->password)) {
                return ['user' => (array)$user, 'token' => md5(time())];
            } else {
                return null;
            }
        } catch (UserNotFound $ex) {
            return null;
        }
    }

    /**
     * @param $token
     * @param Request $request
     */
    public function invited($token, Request $request)
    {
        //Create command for a invited user

        $completedApplicationCommand = new CompletedApplication($token,
                                                                $request->get('email'),
                                                                $request->get('password'),
                                                                $request->get('legal_name'),
                                                                $request->get('known_as'));

        $this->commandBus->execute($completedApplicationCommand);

    }
}