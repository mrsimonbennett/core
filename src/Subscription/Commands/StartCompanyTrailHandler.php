<?php
namespace FullRent\Core\Subscription\Commands;

use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Subscription;
use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;

/**
 * Class StartCompanyTrailHandler
 * @package FullRent\Core\Subscription\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartCompanyTrailHandler
{
    /** @var SubscriptionRepository */
    private $subscriptionRepository;

    /**
     * StartCompanyTrailHandler constructor.
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function handle(StartCompanyTrail $command)
    {
        $subscription = Subscription::startTrail(new SubscriptionId($command->getSubscriptionId()), new CompanyId($command->getCompanyId()));

        $this->subscriptionRepository->save($subscription);
    }
}