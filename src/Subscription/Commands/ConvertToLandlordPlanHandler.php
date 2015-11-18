<?php
namespace FullRent\Core\Subscription\Commands;

use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\ValueObjects\StripeCardToken;

/**
 * Class ConvertToLandlordPlanHandler
 * @package FullRent\Core\Subscription\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ConvertToLandlordPlanHandler
{
    /** @var SubscriptionRepository */
    private $subscriptionRepository;

    /** @var CardPaymentGateWay */
    private $cardPayment;

    /**
     * ConvertToLandlordPlanHandler constructor.
     * @param SubscriptionRepository $subscriptionRepository
     * @param CardPaymentGateWay $cardPayment
     */
    public function __construct(SubscriptionRepository $subscriptionRepository, CardPaymentGateWay $cardPayment)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->cardPayment = $cardPayment;
    }

    /**
     * @param ConvertToLandlordPlan $command
     */
    public function handle(ConvertToLandlordPlan $command)
    {
        $subscription = $this->subscriptionRepository->load($command->getSubscriptionId());

        $subscription->convertToLandlordPlan(new StripeCardToken($command->getCardToken()),$this->cardPayment);

        $this->subscriptionRepository->save($subscription);
    }
}