<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\User\User;
use FullRent\Core\User\UserRepository;

/**
 * Class RegisterUserHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUser $registerUser)
    {
        $user = User::registerUser($registerUser->getUserId(), $registerUser->getName(), $registerUser->getEmail(),
            $registerUser->getPassword(), $registerUser->getTimezone());

        $this->userRepository->save($user);
    }
}