<?php
namespace FullRent\Core\Subscription\Services\CardPayment;

use FullRent\Core\Subscription\ValueObjects\CompanyId;
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
     * @param SubscriptionId $subscriptionId
     * @param CompanyId $companyId
     * @return StripeCustomer
     */
    public function registerCustomerWithNoCard(SubscriptionId $subscriptionId, CompanyId $companyId);

    /**
     * @param StripeCardToken $stripeCardToken
     * @param StripeCustomer $stripCustomer
     * @param string plan
     * @return StripeSubscription
     */
    public function subscribeToPlan(StripeCardToken $stripeCardToken, StripeCustomer $stripCustomer, $plan);
}