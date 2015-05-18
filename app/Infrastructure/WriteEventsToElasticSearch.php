<?php
namespace FullRent\Core\Application\Infrastructure;

use Elasticsearch\Client;

/**
 * Class WriteEventsToElasticSearch
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class WriteEventsToElasticSearch
{
    private $es;

    public function __construct()
    {
        $this->es = new Client(['hosts' => ['http://172.16.1.12:9200']]);
    }

    /**
     * @param $e
     * @hears("FullRent.Core.*")
     */
    public function saveEventToElasticSearch($e)
    {
        $this->es->index([
                             'body'  => ['data' => $e->serialize(),'type' => get_class($e)],
                             'index' => 'fullrent',
                             'type'  => 'event_history',
                             'id'    => uuid(),
                         ]);
    }
}