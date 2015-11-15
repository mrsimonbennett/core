<?php
namespace Domain\Subscription;

use Command;
use FullRent\Core\Subscription\Commands\ConvertToLandlordPlan;
use FullRent\Core\Subscription\Commands\ConvertToLandlordPlanHandler;
use FullRent\Core\Subscription\Events\SubscriptionStripeCustomerRegistered;
use FullRent\Core\Subscription\Events\SubscriptionToLandlordPlanCreated;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\Subscription;
use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\StripeSubscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class ConvertToPayingAccountTest
 * @package Domain\Subscription
 * @author Simon Bennett <simon@bennett.im>
 */
final class ConvertToPayingAccountTest extends \Specification
{

    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        return [
            new SubscriptionTrailStarted(new SubscriptionId(uuid()),
                                         new CompanyId(uuid()),
                                         DateTime::now(),
                                         DateTime::now()->addDays(14)->endOfDay()),
            new SubscriptionStripeCustomerRegistered(new SubscriptionId(uuid()),
                                                     new StripeCustomer('foo123', DateTime::now()),
                                                     DateTime::now())
        ];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new ConvertToLandlordPlan(uuid(), 'token');
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        $cardPayment = $this->getMockBuilder(CardPaymentGateWay::class)->getMock();
        $cardPayment->method('subscribeToPlan')->willReturn(new StripeSubscription('sub123',
                                                                                   'foo123',
                                                                                   DateTime::now(),
                                                                                   DateTime::now()->addMonth()));


        return new ConvertToLandlordPlanHandler($repository, $cardPayment);
    }

    /**
     * @return string
     */
    public function subject()
    {
        return Subscription::class;
    }

    /**
     * @return string
     */
    public function repository()
    {
        return SubscriptionRepository::class;
    }

    public function testEventGenerated()
    {
        $this->assertCount(1, $this->getEvents());
    }

    public function testSubscription()
    {
        /** @var SubscriptionToLandlordPlanCreated $event */
        $event = $this->getEvents()[0];
        $this->assertEquals('sub123', $event->getSubscription()->getSubscriptionId());
        $this->assertEquals('foo123', $event->getSubscription()->getCustomerId());
    }
}