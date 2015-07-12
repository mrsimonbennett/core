<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class ResetUsersPasswordRequestHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetUsersPasswordRequestHandler
{
    /** @var UserRepository */
    private $userRepository;

    /** @var QueryBus */
    private $queryBus;

    /**
     * @param QueryBus $queryBus
     * @param UserRepository $userRepository
     */
    public function __construct(QueryBus $queryBus, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->queryBus = $queryBus;
    }

    /**
     * @param ResetUsersPasswordRequest $command
     */
    public function handle(ResetUsersPasswordRequest $command)
    {
        $userIdString = $this->queryBus->query(new FindUserByEmailQuery($command->getEmail()))->id;

        $user = $this->userRepository->load(new UserId($userIdString));

        $user->requestPasswordReset();

        $this->userRepository->save($user);
    }

}