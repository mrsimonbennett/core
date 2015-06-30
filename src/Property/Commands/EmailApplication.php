<?php
namespace FullRent\Core\Property\Commands;

/**
 * Class EmailApplication
 * @package FullRent\Core\Property\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class EmailApplication
{
    /**
     * @var string
     */
    private $propertyId;
    /**
     * @var string
     */
    private $applicantEmail;

    /**
     * @param string $propertyId
     * @param string $applicantEmail
     */
    public function __construct($propertyId, $applicantEmail)
    {
        $this->propertyId = $propertyId;
        $this->applicantEmail = $applicantEmail;
    }

    /**
     * @return string
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return string
     */
    public function getApplicantEmail()
    {
        return $this->applicantEmail;
    }

}