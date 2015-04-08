<?php
namespace FullRent\Core\Application\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ApplicationFinished
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationFinished implements SerializableInterface
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var DateTime
     */
    private $finishedAt;

    /**
     * @param ApplicationId $applicationId
     * @param DateTime $finishedAt
     */
    public function __construct(ApplicationId $applicationId, DateTime $finishedAt)
    {
        $this->applicationId = $applicationId;
        $this->finishedAt = $finishedAt;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ApplicationId($data['application_id']), DateTime::deserialize($data['finished_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['application_id' => (string)$this->applicationId, 'finished_at' => $this->finishedAt->serialize()];
    }
}