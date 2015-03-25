<?php
namespace FullRent\Core\Contract\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\Rent;

/**
 * Class ContractWasDrafted
 * @package FullRent\Core\Contract\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractWasDrafted implements SerializableInterface
{
    /**
     * @var ContractId
     */
    private $contractId;
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
     * @var Landlord
     */
    private $landlord;

    /**
     * @param ContractId $contractId
     * @param Landlord $landlord
     * @param ContractMinimalPeriod $contractMinimalPeriod
     * @param Property $property
     * @param Rent $rent
     * @param Deposit $deposit
     */
    public function __construct(
        ContractId $contractId,
        Landlord $landlord,
        ContractMinimalPeriod $contractMinimalPeriod,
        Property $property,
        Rent $rent,
        Deposit $deposit
    ) {
        $this->contractId = $contractId;
        $this->contractMinimalPeriod = $contractMinimalPeriod;
        $this->property = $property;
        $this->rent = $rent;
        $this->deposit = $deposit;
        $this->landlord = $landlord;
    }

    /**
     * @return ContractId
     */
    public function getContractId()
    {
        return $this->contractId;
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

    /**
     * @return Landlord
     */
    public function getLandlord()
    {
        return $this->landlord;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new ContractId($data['id']),
                          Landlord::deserialize($data['landlord']),
                          ContractMinimalPeriod::deserialize($data['minimal-period']),
                          Property::deserialize($data['property']),
                          Rent::deserialize($data['rent']),
                          Deposit::deserialize($data['deposit']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id'             => (string)$this->contractId,
            'minimal-period' => $this->contractMinimalPeriod->serialize(),
            'property'       => $this->property->serialize(),
            'landlord'       => $this->landlord->serialize(),
            'rent'           => $this->rent->serialize(),
            'deposit'        => $this->deposit->serialize(),
        ];
    }
}