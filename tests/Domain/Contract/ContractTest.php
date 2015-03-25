<?php

use Carbon\Carbon;
use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\DepositAmount;
use FullRent\Core\Contract\Events\ContractWasDrafted;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\RentAmount;
use FullRent\Core\Contract\ValueObjects\RentDueDay;
use FullRent\Core\Contract\ValueObjects\Tenant;
use FullRent\Core\Contract\ValueObjects\TenantId;
use FullRent\Core\ValueObjects\DateTime;

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
    public function testAttachingTenantToContract()
    {
        $contract = $this->makeContract();
        $contract->attachTenant(new Tenant(TenantId::random()));

        $events = $contract->getUncommittedEvents()->getIterator();
        $this->assertCount(2, $events);
        $this->assertInstanceOf(TenantJoinedContract::class, $events[1]->getPayload());
    }

    /**
     * @return ContractId
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
            DateTime::now()->startOfMonth(),
            DateTime::now()->addMonths(12)->endOfMonth(),
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
        return new Deposit(DepositAmount::fromPounds(100), DateTime::now());
    }

    /**
     * @return Contract
     */
    protected function makeContract()
    {
        $contract = Contract::draftContract($this->makeContractId(),
            new Landlord(LandlordId::random()),
            $this->makeContractDuration(), $this->makeProperty(),
            $this->makeRentAmount(), $this->makeDeposit());

        return $contract;
    }
}