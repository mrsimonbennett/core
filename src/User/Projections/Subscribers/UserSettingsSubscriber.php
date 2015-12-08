<?php namespace FullRent\Core\User\Projections\Subscribers;

use FullRent\Core\User\Events\UserRegistered;
use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;
use FullRent\Core\User\Events\UserHasUpdatedSettings;

/**
 * Class UserSettingsSubscriber
 * @package FullRent\Core\User\Projections\Subscribers
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UserSettingsSubscriber implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * UserSettingsSubscriber constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param UserRegistered $e
     */
    public function whenUserRegistered(UserRegistered $e)
    {
        $table = $this->client
             ->query()
             ->table('user_settings');

        $insert = [
            'user_id' => $e->getUserId(),
        ];

        foreach (config('user.settings') as $setting => $default) {
            $insert[$setting] = $default;
        }

        $table->insert($insert);
    }

    /**
     * @param UserHasUpdatedSettings $e
     */
    public function whenUserHasUpdatedSettings(UserHasUpdatedSettings $e)
    {
        $this->client
            ->query()
            ->table('user_settings')
            ->where('user_id', $e->userId())
            ->update($e->settings());
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            UserRegistered::class         => ['whenUserRegistered'],
            UserHasUpdatedSettings::class => ['whenUserHasUpdatedSettings'],
        ];
    }
}