<?php
namespace FullRent\Core\Application\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ApplicationApproved
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationApproved implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var DateTime
     */
    private $approvedAt;

    /**
     * @param ApplicationId $applicationId
     * @param DateTime $approvedAt
     */
    public function __construct(ApplicationId $applicationId, DateTime $approvedAt)
    {
        $this->applicationId = $applicationId;
        $this->approvedAt = $approvedAt;
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
    public function getApprovedAt()
    {
        return $this->approvedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ApplicationId($data['application_id']), DateTime::deserialize($data['approved_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['application_id' => (string)$this->applicationId, 'approved_at' => $this->approvedAt->serialize()];
    }
}