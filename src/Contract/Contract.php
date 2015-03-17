<?php
namespace FullRent\Core\Contract;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\Contract\Events\ContractWasDrafted;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\Rent;

/**
 * Class Contract
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class Contract extends EventSourcedAggregateRoot
{
    /**
     * @var ContractId
     */
    protected $contractId;
    /**
     * @var ContractMinimalPeriod
     */
    protected $contractMinimalPeriod;
    /**
     * @var Property
     */
    protected $property;
    /**
     * @var Rent
     */
    protected $rent;
    /**
     * @var Deposit
     */
    protected $deposit;
    /**
     * @var Landlord
     */
    protected $landlord;


    /**
     * @param ContractId $contractId
     * @param Landlord $landlord
     * @param ContractMinimalPeriod $contractMinimalPeriod
     * @param Property $property
     * @param Rent $rent
     * @param Deposit $deposit
     * @return static
     */
    public static function draftContract(
        ContractId $contractId,
        Landlord $landlord,
        ContractMinimalPeriod $contractMinimalPeriod,
        Property $property,
        Rent $rent,
        Deposit $deposit
    ) {
        $contract = new static;
        $contract->apply(new ContractWasDrafted($contractId, $landlord, $contractMinimalPeriod, $property, $rent,
            $deposit));

        return $contract;
    }

    /**
     * @param ContractWasDrafted $contractWasDrafted
     */
    public function applyContractWasDrafted(ContractWasDrafted $contractWasDrafted)
    {
        $this->contractId = $contractWasDrafted->getContractId();
        $this->landlord = $contractWasDrafted->getLandlord();
        $this->contractMinimalPeriod = $contractWasDrafted->getContractMinimalPeriod();
        $this->property = $contractWasDrafted->getProperty();
        $this->rent = $contractWasDrafted->getRent();
        $this->deposit = $contractWasDrafted->getDeposit();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->contractId;
    }
}