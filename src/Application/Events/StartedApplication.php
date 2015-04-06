<?php
namespace FullRent\Core\Application\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class StartedApplication
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartedApplication implements SerializableInterface
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var ApplicantId
     */
    private $applicantId;
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var DateTime
     */
    private $startedAt;

    /**
     * @param ApplicationId $applicationId
     * @param ApplicantId $applicantId
     * @param PropertyId $propertyId
     * @param DateTime $startedAt
     */
    public function __construct(
        ApplicationId $applicationId,
        ApplicantId $applicantId,
        PropertyId $propertyId,
        DateTime $startedAt
    ) {
        $this->applicationId = $applicationId;
        $this->applicantId = $applicantId;
        $this->propertyId = $propertyId;
        $this->startedAt = $startedAt;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return ApplicantId
     */
    public function getApplicantId()
    {
        return $this->applicantId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            new ApplicationId($data['id']),
            new ApplicantId($data['applicant_id']),
            new PropertyId($data['property_id']),
            DateTime::deserialize($data['started_at'])
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'           => (string)$this->applicationId,
            'applicant_id' => (string)$this->applicantId,
            'property_id'  => (string)$this->propertyId,
            'started_at'   => $this->startedAt->serialize(),
        ];
    }
}