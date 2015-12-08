<?php namespace FullRent\Core\User\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindUserSettingsHandler
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class FindUserSettingsHandler
{
    /** @var MySqlClient */
    private $client;

    /** @var string[] */
    private $hidden = ['user_id'];

    /**
     * FindUserSettingsHandler constructor.
     *
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindUserSettings $query
     * @return array
     */
    public function handle(FindUserSettings $query)
    {
        $settings = $this->client
            ->query()
            ->table('user_settings')
            ->where('user_id', $query->userId())
            ->first();



        foreach (array_keys((array) $settings) as $setting) {
            if (in_array($setting, $this->hidden)) {
                unset($settings->$setting);
            }
        }

        return $settings;
    }
}