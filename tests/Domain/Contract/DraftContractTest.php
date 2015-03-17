<?php

use Carbon\Carbon;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\DepositAmount;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\RentAmount;
use FullRent\Core\Contract\ValueObjects\RentDueDay;

final class DraftContractTest extends TestCase
{
    public function testBuildingCommand()
    {
        $this->buildCommand();
    }

    public function testRunningCommand()
    {

        $this->bus->execute($this->buildCommand());
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
        return new Rent(RentAmount::fromPounds(100), new RentDueDay(10));
    }

    /**
     * @return Deposit
     */
    protected function makeDeposit()
    {
        return new Deposit(DepositAmount::fromPounds(100), Carbon::now());
    }

    protected function buildCommand()
    {
        return new \FullRent\Core\Contract\DraftContract($this->makeContractId(),
            new Landlord(LandlordId::random()),
            $this->makeContractDuration(), $this->makeProperty(), $this->makeRentAmount(), $this->makeDeposit());
    }

}