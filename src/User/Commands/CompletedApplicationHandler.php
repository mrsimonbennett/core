<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\CommandBus\CommandHandler;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserByEmailQuery;
use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\InviteToken;
use FullRent\Core\User\ValueObjects\Name;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class CompletedApplicationHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompletedApplicationHandler implements CommandHandler
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

    public function handle(CompletedApplication $command)
    {
        $userObj = $this->queryBus->query(new FindUserByEmailQuery($command->getEmail()));

        $user = $this->userRepository->load(new UserId($userObj->id));

        $user->finishApplication(new InviteToken($command->getToken()),
                                 new Password(bcrypt($command->getPassword())),
                                 new Name($command->getLegalName(), $command->getKnownAs()));

        $this->userRepository->save($user);
    }
}