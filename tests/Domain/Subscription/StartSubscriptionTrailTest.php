<?php
namespace Domain\Subscription;


use FullRent\Core\Subscription\Commands\StartCompanyTrail;
use FullRent\Core\Subscription\Commands\StartCompanyTrailHandler;
use FullRent\Core\Subscription\Events\SubscriptionStripeCustomerRegistered;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\Subscription;
use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\ValueObjects\DateTime;
use Specification;

/**
 * Class StartSubscriptionTrailTest
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartSubscriptionTrailTest extends Specification
{

    /**
     * Given events
     *
     * @return array
     */
    public function given()
    {
        [];
    }

    /**
     * @return Command
     */
    public function when()
    {
        return new StartCompanyTrail(uuid(), uuid());
    }

    /**
     * @return mixed
     * @param $repository
     */
    public function handler($repository)
    {
        $cardPayment = $this->getMockBuilder(CardPaymentGateWay::class)->getMock();
        $cardPayment->method('registerCustomerWithNoCard')->willReturn(new StripeCustomer('foo123', DateTime::now()));

        return new StartCompanyTrailHandler($repository, $cardPayment);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return SubscriptionRepository::class;
    }


    /**
     * @return string
     */
    public function subject()
    {
        return Subscription::class;
    }

    /**
     *
     */
    public function testEventCount()
    {
        $this->assertCount(2, $this->getEvents());
    }

    /**
     *
     */
    public function testEventTypesAndOrder()
    {
        $this->assertInstanceOf(SubscriptionTrailStarted::class, $this->getEvents()[0]);
        $this->assertInstanceOf(SubscriptionStripeCustomerRegistered::class, $this->getEvents()[1]);
    }

    /**
     *
     */
    public function testTrailIs14Days()
    {
        /** @var SubscriptionTrailStarted $event */
        $event = $this->getEvents()[0];

        $this->assertEquals(14, $event->getStartedAt()->diffInDays($event->getExpiresAt()));
    }

    /**
     *
     */
    public function testTrailEndsAtTheEndOfTheDay()
    {
        /** @var SubscriptionTrailStarted $event */
        $event = $this->getEvents()[0];

        $this->assertEquals(23, $event->getExpiresAt()->hour);
        $this->assertEquals(59, $event->getExpiresAt()->minute);
    }

    public function testCustomerId()
    {
        /** @var SubscriptionStripeCustomerRegistered $event */
        $event = $this->getEvents()[1];


        $this->assertEquals('foo123', $event->getStripCustomer()->getStripeCustomerId());
    }

}