<?php
namespace FullRent\Core\Contract\Events;


use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractDrafted
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractDrafted implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var ContractId */
    private $contractId;

    /** @var PropertyId */
    private $propertyId;

    /** @var CompanyId */
    private $companyId;

    /** @var LandlordId */
    private $landlordId;

    /** @var Rent */
    private $rentDetails;

    /** @var DateTime */
    private $draftedAt;

    /**
     * ContractDrafted constructor.
     * @param ContractId $contractId
     * @param PropertyId $propertyId
     * @param CompanyId $companyId
     * @param LandlordId $landlordId
     * @param Rent $rentDetails
     * @param DateTime $draftedAt
     */
    public function __construct(
        ContractId $contractId,
        PropertyId $propertyId,
        CompanyId $companyId,
        LandlordId $landlordId,
        Rent $rentDetails,
        DateTime $draftedAt
    ) {
        $this->contractId = $contractId;
        $this->propertyId = $propertyId;
        $this->companyId = $companyId;
        $this->landlordId = $landlordId;
        $this->rentDetails = $rentDetails;
        $this->draftedAt = $draftedAt;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return LandlordId
     */
    public function getLandlordId()
    {
        return $this->landlordId;
    }

    /**
     * @return Rent
     */
    public function getRentDetails()
    {
        return $this->rentDetails;
    }

    /**
     * @return DateTime
     */
    public function getDraftedAt()
    {
        return $this->draftedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['contract_id']),
                          new PropertyId($data['property_id']),
                          new CompanyId($data['company_id']),
                          new LandlordId($data['landlord_id']),
                          Rent::deserialize($data['rent']),
                          DateTime::deserialize($data['drafted_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id' => (string)$this->contractId,
            'company_id'  => (string)$this->companyId,
            'property_id' => (string)$this->propertyId,
            'landlord_id' => (string)$this->landlordId,
            'rent'        => $this->rentDetails->serialize(),
            'drafted_at'  => $this->draftedAt->serialize()
        ];
    }

}