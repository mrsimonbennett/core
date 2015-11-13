<?php
namespace FullRent\Core\Subscription\Services\CardPayment;

use FullRent\Core\Subscription\ValueObjects\StripeCardToken;
use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\StripeSubscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;

/**
 * Interface CardPaymentGateWay
 * @package FullRent\Core\Subscription\Services\CardPaymentGateWay
 * @author Simon Bennett <simon@bennett.im>
 */
interface CardPaymentGateWay
{
    /**
     * @param StripeCardToken $stripeCardToken
     * @param SubscriptionId $subscriptionId
     * @return StripeCustomer
     */
    public function registerCustomer(StripeCardToken $stripeCardToken, SubscriptionId $subscriptionId);

    /**
     * @param StripeCustomer $stripCustomer
     * @param string plan
     * @return StripeSubscription
     */
    public function subscribeToPlan(StripeCustomer $stripCustomer, $plan);
}