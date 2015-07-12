<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\PasswordResetToken;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class ResetUsersPasswordHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetUsersPasswordHandler
{
    /** @var UserRepository */
    private $userRepository;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param UserRepository $userRepository
     * @param QueryBus $queryBus
     */
    public function __construct(UserRepository $userRepository, QueryBus $queryBus)
    {
        $this->userRepository = $userRepository;
        $this->queryBus = $queryBus;
    }

    /**
     * @param ResetUsersPassword $command
     */
    public function handle(ResetUsersPassword $command)
    {
        $userIdString = $this->queryBus->query(new FindUserByEmailQuery($command->getEmail()))->id;

        $user = $this->userRepository->load(new UserId($userIdString));

        $user->resetUserPassword(new Password(bcrypt($command->getNewPassword())),
                                 new PasswordResetToken($command->getToken()));

        $this->userRepository->save($user);
    }
}