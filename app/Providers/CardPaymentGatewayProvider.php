<?php
namespace FullRent\Core\Application\Providers;

use FullRent\Core\Services\CardPayment\CardPaymentGateway;
use FullRent\Core\Services\CardPayment\Stripe\StripeCardPayment;
use Illuminate\Support\ServiceProvider;

/**
 * Class CardPaymentGatewayProvider
 * @package FullRent\Core\Application\Providers
 * @author Simon Bennett <simon@bennett.im>
 */
final class CardPaymentGatewayProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CardPaymentGateway::class, StripeCardPayment::class);
    }
}