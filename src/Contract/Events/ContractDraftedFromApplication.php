<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ApplicationId;
use FullRent\Core\Contract\ValueObjects\CompanyId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ContractDraftedFromApplication
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractDraftedFromApplication implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var ApplicationId
     */
    private $applicationId;
    /**
     * @var PropertyId
     */
    private $propertyId;
    /**
     * @var LandlordId
     */
    private $landlordId;
    /**
     * @var DateTime
     */
    private $draftedAt;
    /**
     * @var CompanyId
     */
    private $companyId;

    /**
     * @param ContractId $contractId
     * @param ApplicationId $applicationId
     * @param PropertyId $propertyId
     * @param LandlordId $landlordId
     * @param CompanyId $companyId
     * @param DateTime $draftedAt
     */
    public function __construct(
        ContractId $contractId,
        ApplicationId $applicationId,
        PropertyId $propertyId,
        LandlordId $landlordId,
        CompanyId $companyId,
        DateTime $draftedAt
    ) {
        $this->contractId = $contractId;
        $this->applicationId = $applicationId;
        $this->propertyId = $propertyId;
        $this->landlordId = $landlordId;
        $this->draftedAt = $draftedAt;
        $this->companyId = $companyId;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return ApplicationId
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * @return PropertyId
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * @return LandlordId
     */
    public function getLandlordId()
    {
        return $this->landlordId;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
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
                          new ApplicationId($data['application_id']),
                          new PropertyId($data['property_id']),
                          new LandlordId($data['landlord_id']),
                          new CompanyId($data['company_id']),
                          DateTime::deserialize($data['drafted_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'contract_id'    => (string)$this->contractId,
            'application_id' => (string)$this->applicationId,
            'property_id'    => (string)$this->propertyId,
            'landlord_id'    => (string)$this->landlordId,
            'company_id'     => (string)$this->companyId,
            'drafted_at'     => $this->draftedAt->serialize()
        ];
    }


}