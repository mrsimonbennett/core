<?php

use FullRent\Core\Contract\Contract;
use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Contract\Events\ContractWasDrafted;
use FullRent\Core\Contract\ValueObjects\ApplicationId;
use FullRent\Core\Contract\ValueObjects\ContractId;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\DepositAmount;
use FullRent\Core\Contract\ValueObjects\Landlord;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\Property;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Tenant;

/**
 * Class ContractTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractTest extends \TestCase
{
    public function testCreatingContract()
    {
        $contract = Contract::draftFromApplication(ContractId::random(),
                                                   ApplicationId::random(),
                                                   PropertyId::random(),
                                                   LandlordId::random());

        $events = $this->events($contract);
        $this->assertCount(1,$events);

        $this->checkCorrectEvent($events,0,ContractDraftedFromApplication::class);
    }
}