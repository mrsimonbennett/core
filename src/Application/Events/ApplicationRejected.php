<?php
namespace FullRent\Core\Application\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\RejectReason;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ApplicationRejected
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationRejected implements SerializableInterface
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var RejectReason
     */
    private $rejectReason;
    /**
     * @var DateTime
     */
    private $rejectedAt;

    /**
     * @param ApplicationId $applicationId
     * @param RejectReason $rejectReason
     * @param DateTime $rejectedAt
     */
    public function __construct(ApplicationId $applicationId, RejectReason $rejectReason, DateTime $rejectedAt)
    {
        $this->applicationId = $applicationId;
        $this->rejectReason = $rejectReason;
        $this->rejectedAt = $rejectedAt;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return RejectReason
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }

    /**
     * @return DateTime
     */
    public function getRejectedAt()
    {
        return $this->rejectedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new ApplicationId($data['application_id']),
            RejectReason::deserialize($data['reason']),
            DateTime::deserialize($data['rejected_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'application_id' => (string)$this->applicationId,
            'reason'         => $this->rejectReason->serialize(),
            'rejected_at'    => $this->rejectedAt->serialize()
        ];
    }
}