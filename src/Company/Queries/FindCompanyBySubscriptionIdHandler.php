<?php
namespace FullRent\Core\Company\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindCompanyBySubscriptionIdHandler
 * @package FullRent\Core\Company\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyBySubscriptionIdHandler
{
    /** @var MySqlClient */
    private $client;

    /**
     * FindCompanyBySubscriptionIdHandler constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param FindCompanyBySubscriptionId $query
     * @return mixed|static
     */
    public function handle(FindCompanyBySubscriptionId $query)
    {
        return $this->client->query()
                            ->table('companies')
                            ->where('subscription_id', $query->getSubscriptionId())
                            ->first();
    }
}