<?php
namespace FullRent\Core\Property\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Property\Exceptions\PropertyNotFound;

/**
 * Class FindPropertyByIdHandler
 * @package FullRent\Core\Property\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindPropertyByIdHandler
{
    /**
     * @var MySqlClient
     */
    private $client;

    /**
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    public function handle(FindPropertyById $query)
    {
        if (is_null($property = $this->client->query()->table('properties')->where('id', $query->getPropertyId())->first())) {
            throw new PropertyNotFound;
        }

        return $property;
    }
}