<?php
namespace FullRent\Core\Contract\Commands;

use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;

/**
 * Class DraftContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftContract
{

    /**
     * @var ContractId
     */
    private $contractId;
    /**
     * @var Landlord
     */
    private $landlord;
    /**
     * @var ContractMinimalPeriod
     */
    private $contractMinimalPeriod;
    /**
     * @var Property
     */
    private $property;
    /**
     * @var Rent
     */
    private $rent;
    /**
     * @var Deposit
     */
    private $deposit;

    /**
     * @param LandlordId $landlordId
     * @param ContractMinimalPeriod $contractMinimalPeriod
     * @param PropertyId $propertyId
     * @param Rent $rent
     * @param Deposit $deposit
     */
    public function __construct(
        LandlordId $landlordId,
        ContractMinimalPeriod $contractMinimalPeriod,
        PropertyId $propertyId,
        Rent $rent,
        Deposit $deposit
    ) {
        $this->contractId = ContractId::random();
        $this->landlord = new Landlord($landlordId);
        $this->contractMinimalPeriod = $contractMinimalPeriod;
        $this->property = new Property($propertyId);
        $this->rent = $rent;
        $this->deposit = $deposit;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return Landlord
     */
    public function getLandlord()
    {
        return $this->landlord;
    }

    /**
     * @return ContractMinimalPeriod
     */
    public function getContractMinimalPeriod()
    {
        return $this->contractMinimalPeriod;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return Rent
     */
    public function getRent()
    {
        return $this->rent;
    }

    /**
     * @return Deposit
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

}