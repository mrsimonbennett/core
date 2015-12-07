<?php
namespace FullRent\Core\Subscription\Listeners;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;
use FullRent\Core\Subscription\Events\SubscriptionToLandlordPlanCreated;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class SubscriptionMysqlListener
 * @package FullRent\Core\Subscription\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionMysqlListener implements Subscriber, Projection
{
    /** @var MySqlClient */
    private $client;

    /**
     * SubscriptionMysqlListener constructor.
     * @param MySqlClient $client
     */
    public function __construct(MySqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * When a company trail starts (When they reg the company) update the mysql table to store the expiry date
     * @param SubscriptionTrailStarted $e
     */
    public function whenTrailStartedUpdateCompany(SubscriptionTrailStarted $e)
    {
        $this->client
            ->query()
            ->table('companies')
            ->where('id', $e->getCompanyId())
            ->update([
                         'trial_expires'   => $e->getExpiresAt(),
                         'subscription_id' => $e->getId(),
                     ]);
    }

    public function whenConvenedToPlan(SubscriptionToLandlordPlanCreated $e)
    {
        $this->client
            ->query()
            ->table('companies')
            ->where('subscription_id', $e->getId())
            ->update([
                         'trial_expires'           => null,
                         'subscription_id'         => $e->getId(),
                         'subscription_plan'       => 'landlord',
                         'subscription_plan_name'  => 'Landlord Plan',
                         'subscription_started_at' => $e->getSubscription()->getPeriodStart(),
                     ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            SubscriptionTrailStarted::class          => ['whenTrailStartedUpdateCompany'],
            SubscriptionToLandlordPlanCreated::class => ['whenConvenedToPlan'],
        ];
    }
}