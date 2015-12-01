<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\User;
use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\Email;
use FullRent\Core\User\ValueObjects\InviteToken;
use FullRent\Core\User\ValueObjects\UserId;

/**
 * Class InviteUserHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class InviteUserHandler
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param InviteUser $command
     */
    public function handle(InviteUser $command)
    {
        $user = User::inviteUser(new UserId($command->getUserId()),
                                 new Email($command->getEmail()),
                                 new InviteToken($command->getCode()));

        $this->userRepository->save($user);
    }
}