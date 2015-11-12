<?php
namespace Domain\Subscription;


use FullRent\Core\Subscription\Commands\StartCompanyTrail;
use FullRent\Core\Subscription\Commands\StartCompanyTrailHandler;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Subscription;
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
        return new StartCompanyTrailHandler($repository);
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


    public function testCompanyStartedTrail()
    {
        $this->assertInstanceOf(SubscriptionTrailStarted::class, $this->getEvents()[0]);
    }
}