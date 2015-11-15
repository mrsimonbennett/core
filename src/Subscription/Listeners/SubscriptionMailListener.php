<?php
namespace FullRent\Core\Subscription\Listeners;

use FullRent\Core\Company\Queries\FindCompanyBySubscriptionId;
use FullRent\Core\Infrastructure\Email\EmailClient;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\Subscription\Events\SubscriptionToLandlordPlanCreated;
use FullRent\Core\User\Queries\FindCompanyLandlord;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class SubscriptionMailListener
 * @package FullRent\Core\Subscription\Listeners
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionMailListener implements Subscriber, Projection
{
    /** @var EmailClient */
    private $client;

    /** @var QueryBus */
    private $queryBus;

    /**
     * SubscriptionMailListener constructor.
     * @param EmailClient $client
     * @param QueryBus $queryBus
     */
    public function __construct(EmailClient $client, QueryBus $queryBus)
    {
        $this->client = $client;
        $this->queryBus = $queryBus;
    }

    /**
     * @param SubscriptionToLandlordPlanCreated $e
     */
    public function convertedToLandlordPlan(SubscriptionToLandlordPlanCreated $e)
    {
        $company = $this->queryBus->query(new FindCompanyBySubscriptionId($e->getId()));

        $landlord = $this->queryBus->query(new FindCompanyLandlord($company->id));

        $this->client->send('subscriptions.thank-you',
                            'Thank you for Subscribing to the Landlord Plan',
                            [
                                'company'  => $company,
                                'landlord' => $landlord
                            ],
                            $landlord->known_as,
                            $landlord->email);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            SubscriptionToLandlordPlanCreated::class => ['convertedToLandlordPlan'],
        ];
    }
}