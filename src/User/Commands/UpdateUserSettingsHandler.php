<?php namespace FullRent\Core\User\Commands;

use FullRent\Core\User\UserRepository;

/**
 * Class UpdateUserSettingsHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdateUserSettingsHandler
{
    /** @var UserRepository */
    private $repository;

    /**
     * UpdateUserSettingsHandler constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UpdateUserSettings $command
     */
    public function handle(UpdateUserSettings $command)
    {
        $user = $this->repository->load($command->userId());

        $user->updateSettings($command->settings());

        $this->repository->save($user);
    }
}