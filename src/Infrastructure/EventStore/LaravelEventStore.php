<?php
namespace FullRent\Core\Infrastructure\EventStore;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainEventStreamInterface;
use Broadway\Domain\DomainMessage;
use Broadway\EventStore\DBALEventStoreException;
use Broadway\EventStore\EventStoreInterface;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Serializer\SerializerInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\QueryException;

/**
 * Class LaravelEventStore
 * @package FullRent\Core\Infrastructure\EventStore
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelEventStore implements EventStoreInterface
{
    /**
     * @var Connection
     */
    private $db;
    /**
     * @var SerializerInterface
     */
    private $payloadSerializer;
    /**
     * @var SerializerInterface
     */
    private $metadataSerializer;

    /**
     * @param DatabaseManager $databaseManager
     * @param SerializerInterface $payloadSerializer
     * @param SerializerInterface $metadataSerializer
     */
    public function __construct(
        DatabaseManager $databaseManager,
        SerializerInterface $payloadSerializer,
        SerializerInterface $metadataSerializer
    ) {
        $this->db = $databaseManager;
        $this->payloadSerializer = $payloadSerializer;
        $this->metadataSerializer = $metadataSerializer;
    }

    /**
     * @param mixed $id
     *
     * @return DomainEventStreamInterface
     */
    public function load($id)
    {
        $rows = $this->db->connection('eventstore')->table('eventstore')
                         ->select(['uuid', 'playhead', 'metadata', 'payload', 'recorded_on'])
                         ->where('uuid', $id)
                         ->orderBy('playhead', 'asc')
                         ->get();
        $events = [];

        foreach ($rows as $row) {
            $events[] = $this->deserializeEvent($row);
        }

        if (empty($events)) {
            throw new EventStreamNotFoundException(sprintf('EventStream not found for aggregate with id %s', $id));
        }

        return new DomainEventStream($events);

    }

    /**
     * @param mixed $id
     * @param DomainEventStreamInterface $eventStream
     */
    public function append($id, DomainEventStreamInterface $eventStream)
    {
        $id = (string)$id; //Used to thrown errors if ID will not cast to string

        $this->db->beginTransaction();

        try {
            foreach ($eventStream as $domainMessage) {
                $this->insertEvent($this->db, $domainMessage);
            }

            $this->db->commit();
        } catch (QueryException $ex) {
            $this->db->rollBack();

            throw $ex;
        }
    }

    /**
     * @param Connection $db
     * @param $domainMessage
     */
    private function insertEvent($db, $domainMessage)
    {
        $data = array(
            'uuid'        => (string)$domainMessage->getId(),
            'playhead'    => $domainMessage->getPlayhead(),
            'metadata'    => json_encode($this->metadataSerializer->serialize($domainMessage->getMetadata())),
            'payload'     => json_encode($this->payloadSerializer->serialize($domainMessage->getPayload())),
            'recorded_on' => $domainMessage->getRecordedOn()->toString(),
            'type'        => $domainMessage->getType(),
        );
        $db->connection('eventstore')->table('eventstore')->insert($data);
    }

    /**
     * @param \stdClass
     * @return DomainMessage
     */
    private function deserializeEvent($row)
    {
        return new DomainMessage(
            $row->uuid,
            $row->playhead,
            $this->metadataSerializer->deserialize(json_decode($row->metadata, true)),
            $this->payloadSerializer->deserialize(json_decode($row->payload, true)),
            DateTime::fromString($row->recorded_on)
        );
    }
}