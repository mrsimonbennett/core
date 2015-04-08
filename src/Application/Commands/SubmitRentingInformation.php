<?php
namespace FullRent\Core\Application\Commands;

use FullRent\Core\Application\ValueObjects\ApplicationId;
use FullRent\Core\Application\ValueObjects\RentingInformation;

/**
 * Class SubmitRentingInformation
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubmitRentingInformation
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
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return RentingInformation
     */
    public function getRentingInformation()
    {
        return $this->rentingInformation;
    }

}