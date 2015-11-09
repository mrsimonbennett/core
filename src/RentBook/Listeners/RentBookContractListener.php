<?php
namespace FullRent\Core\RentBook\Listeners;

use DateInterval;
use DatePeriod;
use FullRent\Core\Contract\Events\LandlordSignedContract;
use FullRent\Core\Contract\Events\TenantJoinedContract;
use FullRent\Core\Contract\Query\FindContractByIdQuery;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\RentBook\Commands\OpenAutomaticRentBook;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class RentBookContractListener
 * @package FullRent\Core\RentBook\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookContractListener implements Subscriber
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * So when a contract is finished make a new rent book for them.
     *
     * Automatic rent book for contracts that use fullrent for rent collection
     * @todo Chnage this event to contract active event
     * @todo Add in manally rent book generator
     * @param LandlordSignedContract $e
     */
    public function whenTenantJoinedContract(TenantJoinedContract $e)
    {
        $contract = $this->queryBus->query(new FindContractByIdQuery($e->getContractId()));

        \Log::debug(json_decode(json_encode($contract), true));

        if ($contract->fullrent_rent_collection) {
            $this->fullrentCollection($contract);
        }

    }


    /**
     * @param $contract
     * @return array
     */
    private function formatKeyDates($contract)
    {
        $startDate = (new DateTime($contract->start))->startOfDay();
        $endDate = (new DateTime($contract->end))->startOfDay();
        $firstRent = (new DateTime($contract->first_rent))->startOfDay();

        return array($startDate, $endDate, $firstRent);
    }

    /**
     * @param $contract
     */
    private function fullrentCollection($contract)
    {
        \Log::debug(json_encode($contract));

        list($startDate, $endDate, $firstRent) = $this->formatKeyDates($contract);

        $rentDueDay = $contract->rent_payable;

        $rentStartDay = DateTime::create($startDate->year, $startDate->month, $rentDueDay, 0, 0, 0);

        $period = new DatePeriod($rentStartDay, new DateInterval('P1M'), $endDate);

        foreach ($period as $dueDate) {
            if ($dueDate >= $startDate) {
                $rentDays[] = new DateTime($dueDate);
            }
        }
        if ($firstRent < $rentDays[0]) {
            $rentDays[0] = $firstRent;
        }


        for ($i = 0; $i < count($rentDays); $i++) {
            if ($rentDays[$i]->isPast()) {
                $rentDays[$i] = DateTime::now()->addDay();
            }
        }

        foreach ($contract->tenants as $tenant) {
            $this->commandBus->execute(new OpenAutomaticRentBook(uuid(),
                                                                 $contract->id,
                                                                 $tenant->id,
                                                                 $contract->rent,
                                                                 $rentDays));
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            TenantJoinedContract::class => ['whenTenantJoinedContract'],
        ];
    }

    /**
     * @return array
     */
    protected function registerOnce()
    {

    }
}