<?php
namespace FullRent\Core\Subscription;

use FullRent\Core\Infrastructure\FullRentServiceProvider;
use FullRent\Core\Subscription\Listeners\CompanyRegisteredListener;
use FullRent\Core\Subscription\Listeners\SubscriptionMailListener;
use FullRent\Core\Subscription\Listeners\SubscriptionMysqlListener;
use FullRent\Core\Subscription\Repository\SmoothSubscriptionRepository;
use FullRent\Core\Subscription\Repository\SubscriptionRepository;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\Services\CardPayment\Stripe\StripeCardPaymentGateway;

/**
 * Class SubscriptionServiceProvider
 * @package FullRent\Core\Subscription
 * @author Simon Bennett <simon@bennett.im>
 */
final class SubscriptionServiceProvider extends FullRentServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SubscriptionRepository::class, SmoothSubscriptionRepository::class);
        $this->app->bind(CardPaymentGateWay::class, StripeCardPaymentGateway::class);
    }

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [
            SubscriptionMysqlListener::class,
            CompanyRegisteredListener::class,
            SubscriptionMailListener::class,
        ];
    }
}