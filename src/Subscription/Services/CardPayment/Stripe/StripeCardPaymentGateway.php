<?php
namespace FullRent\Core\Subscription\Services\CardPayment\Stripe;

use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\Services\CardPayment\plan;
use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\StripeCardToken;
use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\StripeSubscription;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Log\Writer;
use Stripe\Customer;
use Stripe\Stripe;

/**
 * Class StripeCardPaymentGateway
 * @package FullRent\Core\Subscription\Services\CardPayment\Stripe
 * @author Simon Bennett <simon@bennett.im>
 */
final class StripeCardPaymentGateway implements CardPaymentGateWay
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Writer
     */
    private $writer;

    /**
     * @param Repository $config
     * @param Writer $writer
     */
    public function __construct(Repository $config, Writer $writer)
    {
        $this->config = $config;
        $this->writer = $writer;
        Stripe::setApiKey($config->get('services.stripe.secret'));
    }

    /**
     * @param SubscriptionId $subscriptionId
     * @param CompanyId $companyId
     * @return StripeCustomer
     */
    public function registerCustomerWithNoCard(SubscriptionId $subscriptionId, CompanyId $companyId)
    {
        $customer = Customer::create(array('description' => "Subscription for companyId: {$companyId} : Subscription: {$subscriptionId} "));

        $this->writer->log('info', $customer);

        return new StripeCustomer($customer['id'], DateTime::createFromTimestampUTC($customer['created']));
    }

    /**
     * @param StripeCardToken $stripeCardToken
     * @param StripeCustomer $stripCustomer
     * @param string plan
     * @return StripeSubscription
     */
    public function subscribeToPlan(StripeCardToken $stripeCardToken, StripeCustomer $stripCustomer, $plan)
    {
        $customer = Customer::retrieve($stripCustomer->getStripeCustomerId());

        $sub = $customer->subscriptions->create(['plan' => $plan, 'source' => $stripeCardToken->getCardToken()]);

        return new StripeSubscription($sub['id'],
                                      $stripCustomer->getStripeCustomerId(),
                                      DateTime::createFromTimestampUTC($sub['current_period_start']),
                                      DateTime::createFromTimestampUTC($sub['current_period_end']));

    }
}