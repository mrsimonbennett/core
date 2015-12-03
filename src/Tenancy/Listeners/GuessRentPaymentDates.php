<?php
namespace FullRent\Core\Tenancy\Listeners;

use DateInterval;
use DatePeriod;
use FullRent\Core\Tenancy\Commands\ScheduleTenancyRentPayment;
use FullRent\Core\Tenancy\Events\TenancyDrafted;
use FullRent\Core\Tenancy\ValueObjects\RentFrequency;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class GuessRentPaymentDates
 * @package FullRent\Core\Tenancy\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class GuessRentPaymentDates implements Subscriber
{
    /** @var CommandBus */
    private $commandBus;

    /**
     * GuessRentPaymentDates constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param TenancyDrafted $e
     */
    public function whenTenancyDrafted(TenancyDrafted $e)
    {
        if ($e->getRentDetails()->getRentFrequency()->getRentFrequency() == 'irregular') {
            return;
        }

        $rentStartDay = DateTime::create($e->getTenancyDuration()->getStart()->year,
                                         $e->getTenancyDuration()->getStart()->month,
                                         1,
                                         0,
                                         0,
                                         0);


        $period = new DatePeriod($rentStartDay,
                                 $this->buildDateInterval($e->getRentDetails()->getRentFrequency()),
                                 $e->getTenancyDuration()->getEnd());


        foreach ($period as $dueDate) {
            if ($dueDate >= $e->getTenancyDuration()->getStart()->startOfDay()) {
                $this->commandBus->execute(new ScheduleTenancyRentPayment(uuid(),
                                                                          (string)$e->getTenancyId(),
                                                                          $e->getRentDetails()->getRentAmount()
                                                                            ->getAmountInPounds(),
                                                                          (new DateTime($dueDate))->format('d/m/Y')));

            }
        }


    }

    /**
     * ['eventName' => 'methodName']
     * ['eventName' => ['methodName', $priority]]
     * ['eventName' => [['methodName1', $priority], array['methodName2']]
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            TenancyDrafted::class => 'whenTenancyDrafted',
        ];
    }

    /**
     * @param RentFrequency $rentFrequency
     * @return DateInterval
     */
    protected function buildDateInterval(RentFrequency $rentFrequency)
    {
        return new DateInterval('P' . $rentFrequency->convertToPeriod());
    }
}