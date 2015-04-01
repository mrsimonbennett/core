<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\User\Exceptions\UserNotFoundException;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\UserId;
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
     * @param UserReadRepository $userRepository
     */
    public function __construct(UserReadRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     * @return array|null
     */
    public function show($userId)
    {
        try{
            $user = $this->userRepository->getById(new UserId($userId));
            return (array) $user;
        }catch(UserNotFoundException $ex){
            return null;
        }
    }
}