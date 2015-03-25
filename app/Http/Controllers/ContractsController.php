<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Requests\DraftContractHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Contract\Commands\DraftContract;
use FullRent\Core\Contract\ValueObjects\ContractMinimalPeriod;
use FullRent\Core\Contract\ValueObjects\Deposit;
use FullRent\Core\Contract\ValueObjects\DepositAmount;
use FullRent\Core\Contract\ValueObjects\LandlordId;
use FullRent\Core\Contract\ValueObjects\PropertyId;
use FullRent\Core\Contract\ValueObjects\Rent;
use FullRent\Core\Contract\ValueObjects\RentAmount;
use FullRent\Core\Contract\ValueObjects\RentDueDay;
use FullRent\Core\ValueObjects\DateTime;
use Illuminate\Routing\Controller;

/**
 * Class ContractsController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractsController extends Controller
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function draftContract(DraftContractHttpRequest $request)
    {
        $command = new DraftContract(new LandlordId($request->get('landlord_id')),
            new ContractMinimalPeriod(
                DateTime::createFromFormat('d/m/Y', $request->get('start_date')),
                DateTime::createFromFormat('d/m/Y', $request->get('end_date')),
                $request->get('rolls')
            ),
            new PropertyId($request->get('property_id')),
            new Rent(RentAmount::fromPounds($request->get('rent')), new RentDueDay((int)$request->get('rent_due_day'))),
            new Deposit(DepositAmount::fromPounds($request->get('deposit')),
                DateTime::createFromFormat('d/m/Y', $request->get('deposit_due'))));

        $this->bus->execute($command);
    }
}