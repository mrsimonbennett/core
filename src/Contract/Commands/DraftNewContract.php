<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class DraftNewContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftNewContract
{
    /** @var string */
    private $contractId;

    /** @var string */
    private $propertyId;

    /** @var string */
    private $companyId;

    /** @var string */
    private $start;

    /** @var string */
    private $end;

    /** @var string */
    private $rent;

    /** @var string */
    private $firstPaymentDue;

    /** @var string */
    private $rentPayable;

    /** @var string */
    private $fullrentRentCollection;

    /** @var string */
    private $landlordId;

    /**
     * DraftNewContract constructor.
     * @param string $contractId
     * @param string $propertyId
     * @param string $companyId
     * @param string $landlordId
     * @param string $start
     * @param string $end
     * @param string $rent
     * @param string $firstPaymentDue
     * @param string $rentPayable
     * @param string $fullrentRentCollection
     */
    public function __construct($contractId,$propertyId,$companyId,$landlordId, $start,$end, $rent, $firstPaymentDue, $rentPayable, $fullrentRentCollection)
    {
        $this->contractId = $contractId;
        $this->propertyId = $propertyId;
        $this->companyId = $companyId;
        $this->start = $start;
        $this->end = $end;
        $this->rent = $rent;
        $this->firstPaymentDue = $firstPaymentDue;
        $this->rentPayable = $rentPayable;
        $this->fullrentRentCollection = $fullrentRentCollection;
        $this->landlordId = $landlordId;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
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
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getLandlordId()
    {
        return $this->landlordId;
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
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @return string
     */
    public function getFirstPaymentDue()
    {
        return $this->firstPaymentDue;
    }

    /**
     * @return string
     */
    public function getRentPayable()
    {
        return $this->rentPayable;
    }

    /**
     * @return string
     */
    public function getFullrentRentCollection()
    {
        return $this->fullrentRentCollection;
    }

}