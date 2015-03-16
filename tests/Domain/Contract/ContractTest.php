<?php

use Carbon\Carbon;
use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\ContractId;
use FullRent\Core\Contract\ContractMinimalPeriod;
use FullRent\Core\Contract\Deposit;
use FullRent\Core\Contract\DepositAmount;
use FullRent\Core\Contract\Events\ContractWasDrafted;
use FullRent\Core\Contract\Property;
use FullRent\Core\Contract\PropertyId;
use FullRent\Core\Contract\Rent;
use FullRent\Core\Contract\RentAmount;

/**
 * Class ContractTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractTest extends \TestCase
{
    /**
     *
     */
    public function testDraftingNewContract()
    {
        $contract = $this->makeContract();
        $events = $contract->getUncommittedEvents()->getIterator();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(ContractWasDrafted::class, $events[0]->getPayload());
    }

    /**
     * @return \Rhumsaa\Uuid\Uuid
     */
    protected function makeContractId()
    {
        return ContractId::random();
    }

    /**
     * @return ContractMinimalPeriod
     */
    protected function makeContractDuration()
    {
        return new ContractMinimalPeriod(
            Carbon::now()->startOfMonth(),
            Carbon::now()->addMonths(12)->endOfMonth(),
            false);
    }

    /**
     * @return Property
     */
    protected function makeProperty()
    {
        return new Property(PropertyId::random());
    }

    /**
     * @return Rent
     */
    protected function makeRentAmount()
    {
        return new Rent(RentAmount::fromPounds(100));
    }

    /**
     * @return Deposit
     */
    protected function makeDeposit()
    {
        return new Deposit(DepositAmount::fromPounds(100), Carbon::now());
    }

    /**
     * @return static
     */
    protected function makeContract()
    {
        $contract = Contract::draftContract($this->makeContractId(),
            $this->makeContractDuration(), $this->makeProperty(),
            $this->makeRentAmount(), $this->makeDeposit());

        return $contract;
    }
}