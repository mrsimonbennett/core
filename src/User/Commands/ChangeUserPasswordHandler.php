<?php
namespace FullRent\Core\User\Commands;

use FullRent\Core\User\UserRepository;
use FullRent\Core\User\ValueObjects\Password;
use FullRent\Core\User\ValueObjects\UserId;
use Illuminate\Contracts\Hashing\Hasher;

/**
 * Class ChangeUserPasswordHandler
 * @package FullRent\Core\User\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeUserPasswordHandler
{
    /** @var UserRepository */
    private $userRepository;

    /** @var Hasher */
    private $hasher;

    /**
     * ChangeUserPasswordHandler constructor.
     * @param UserRepository $userRepository
     * @param Hasher $hasher
     */
    public function __construct(UserRepository $userRepository, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * @param ChangeUserPassword $command
     */
    public function handle(ChangeUserPassword $command)
    {
        $user = $this->userRepository->load(new UserId($command->getUserId()));
        \Log::debug($command->getOldPassword());
        $user->changePassword($command->getOldPassword(),
                              new Password($this->hasher->make($command->getNewPassword())),
                              $this->hasher);

        $this->userRepository->save($user);
    }
}