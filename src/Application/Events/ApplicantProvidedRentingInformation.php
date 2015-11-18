<?php
namespace FullRent\Core\Application\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\RentingInformation;

/**
 * Class ApplicantProvidedRentingInformation
 * @package FullRent\Core\Application\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicantProvidedRentingInformation implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var RentingInformation
     */
    private $rentingInformation;

    /**
     * @param ApplicationId $applicationId
     * @param RentingInformation $rentingInformation
     */
    public function __construct(ApplicationId $applicationId, RentingInformation $rentingInformation)
    {
        $this->applicationId = $applicationId;
        $this->rentingInformation = $rentingInformation;
    }

    /**
     * @return RentingInformation
     */
    public function getRentingInformation()
    {
        return $this->rentingInformation;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ApplicationId($data['application_id']),
                          RentingInformation::deserialize($data['renting_information']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'application_id'      => (string)$this->applicationId,
            'renting_information' => $this->rentingInformation->serialize()
        ];
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }
}