<?php
namespace FullRent\Core\Tenancy\Commands;

/**
 * Class DraftTenancy
 * @package FullRent\Core\Tenancy\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftTenancy
{
    private $tenancyId;

    private $propertyId;

    private $start;

    private $end;

    private $rentAmount;

    private $rentFrequency;

    /**
     * DraftTenancy constructor.
     * @param string $tenancyId
     * @param string $propertyId
     * @param string $start
     * @param string $end
     * @param string $rentAmount
     * @param string $rentFrequency
     */
    public function __construct($tenancyId, $propertyId, $start, $end, $rentAmount, $rentFrequency)
    {
        $this->tenancyId = $tenancyId;
        $this->propertyId = $propertyId;
        $this->start = $start;
        $this->end = $end;
        $this->rentAmount = $rentAmount;
        $this->rentFrequency = $rentFrequency;
    }

    /**
     * @return string
     */
    public function getTenancyId()
    {
        return $this->tenancyId;
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
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getRentAmount()
    {
        return $this->rentAmount;
    }

    /**
     * @return string
     */
    public function getRentFrequency()
    {
        return $this->rentFrequency;
    }

}