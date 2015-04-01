<?php
namespace FullRent\Core\Application\Http\Controllers\Auth;

use FullRent\Core\User\Exceptions\UserNotFoundException;
use FullRent\Core\User\Projections\UserReadRepository;
use FullRent\Core\User\ValueObjects\Email;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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

    /**
     * @param UserReadRepository $userRepository
     * @param Hasher $hasher
     */
    public function __construct(UserReadRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }
    public function postLogin(Request $request)
    {
        try{
            $user = $this->userRepository->getByEmail(new Email($request->get('email')));
            if ($this->hasher->check($request->get('password'), $user->password)) {
                return (array)$user;
            }
            else{
                return null;
            }
        }catch(UserNotFoundException $ex){
            return null;
        }
    }
}