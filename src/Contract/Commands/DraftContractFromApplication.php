<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class DraftContractFromApplication
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftContractFromApplication
{
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $applicationId;
    /**
     * @var string
     */
    private $propertyId;
    /**
     * @var string
     */
    private $landlordId;
    /**
     * @var string
     */
    private $companyId;

    /**
     * @param string $contractId
     * @param string $applicationId
     * @param string $propertyId
     * @param string $companyId
     * @param string $landlordId
     */
    public function __construct(
        $contractId,
        $applicationId,
        $propertyId,
        $companyId,
        $landlordId
    ) {
        $this->contractId = $contractId;
        $this->applicationId = $applicationId;
        $this->propertyId = $propertyId;
        $this->landlordId = $landlordId;
        $this->companyId = $companyId;
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
    public function getApplicationId()
    {
        return $this->applicationId;
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
    public function getLandlordId()
    {
        return $this->landlordId;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

}