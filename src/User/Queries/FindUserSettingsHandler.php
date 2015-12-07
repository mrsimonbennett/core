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
        return $this->client
            ->query()
            ->table('user_settings')
            ->where('user_id', $query->userId())
            ->first();
    }
}