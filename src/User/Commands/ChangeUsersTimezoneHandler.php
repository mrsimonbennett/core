<?php namespace FullRent\Core\User\Commands;

use FullRent\Core\User\UserRepository;
use FullRent\Core\CommandBus\CommandHandler;

/**
 * Class ChangeUsersTimezoneHandler
 *
 * @package FullRent\Core\User\Commands
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class ChangeUsersTimezoneHandler implements CommandHandler
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
     * @param ChangeUsersTimezone $command
     */
    public function handle(ChangeUsersTimezone $command)
    {
        $user = $this->userRepository->load($command->getUserId());
        $user->changeTimezone($command->getTimezone());

        $this->userRepository->save($user);
    }
}