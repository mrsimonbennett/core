<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\UserRepository;

/**
 * Class ChangeUsersEmailAddressHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeUsersEmailAddressHandler
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * ChangeUsersEmailAddressHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ChangeUsersEmailAddress $command
     */
    public function handle(ChangeUsersEmailAddress $command)
    {
        $user = $this->userRepository->load(new UserId($command->getUserId()));

        $user->changeEmail(new Email($command->getEmail()));

        $this->userRepository->save($user);
    }
}