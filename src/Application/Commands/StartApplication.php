<?php
namespace FullRent\Core\Application\Commands;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Application\ValueObjects\ApplicantId;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\PropertyId;

/**
 * Class StartApplication
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartApplication
{
    /**
     * @var ApplicantId
     */
    private $applicantId;
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var ApplicationId
     */
    private $applicationId;

    /**
     * @param ApplicantId $applicantId
     * @param PropertyId $propertyId
     */
    public function __construct(ApplicantId $applicantId, PropertyId $propertyId)
    {
        $this->applicationId = ApplicationId::random();
        $this->applicantId = $applicantId;
        $this->propertyId = $propertyId;
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
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }


}