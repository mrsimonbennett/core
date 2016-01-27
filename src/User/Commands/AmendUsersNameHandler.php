<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class AmendUsersNameHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class AmendUsersNameHandler
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * AmendUsersNameHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param AmendUsersName $command
     */
    public function handle(AmendUsersName $command)
    {
        $user = $this->userRepository->load(new UserId($command->getUserId()));

        $user->amendName(new Name($command->getLegalName(),$command->getKnownAs()));

        $this->userRepository->save($user);
    }
}