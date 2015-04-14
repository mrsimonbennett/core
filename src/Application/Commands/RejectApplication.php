<?php
namespace FullRent\Core\Application\Commands;

/**
 * Class RejectApplication
 * @package FullRent\Core\Application\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RejectApplication 
{
    /**
     * @var string
     */
    private $applicationId;
    /**
     * @var string
     */
    private $rejectReason;

    /**
     * @param string $applicationId
     * @param string $rejectReason
     */
    public function __construct($applicationId, $rejectReason)
    {
        $this->applicationId = $applicationId;
        $this->rejectReason = $rejectReason;
    }

    /**
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return string
     */
    public function getRejectReason()
    {
        return $this->rejectReason;
    }

}