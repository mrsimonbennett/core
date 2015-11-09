<?php
namespace FullRent\Core\Property\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Property\ValueObjects\ApplicantEmail;
use FullRent\Core\Property\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ApplicantInvitedToApplyByEmail
 * @package FullRent\Core\Property\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicantInvitedToApplyByEmail implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var ApplicantEmail
     */
    private $applicantEmail;
    /**
     * @var DateTime
     */
    private $invitedAt;

    /**
     * @param PropertyId $propertyId
     * @param ApplicantEmail $applicantEmail
     * @param DateTime $invitedAt
     */
    public function __construct(PropertyId $propertyId, ApplicantEmail $applicantEmail, DateTime $invitedAt)
    {
        $this->propertyId = $propertyId;
        $this->applicantEmail = $applicantEmail;
        $this->invitedAt = $invitedAt;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return ApplicantEmail
     */
    public function getApplicantEmail()
    {
        return $this->applicantEmail;
    }

    /**
     * @return DateTime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new PropertyId($data['property_id']),
                          ApplicantEmail::deserialize($data['applicant_email']),
                          DateTime::deserialize($data['invited_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'property_id'     => (string)$this->propertyId,
            'applicant_email' => $this->applicantEmail->serialize(),
            'invited_at'      => $this->invitedAt->serialize()
        ];
    }
}