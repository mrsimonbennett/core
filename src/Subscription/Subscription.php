<?php
namespace FullRent\Core\Subscription;

use FullRent\Core\Subscription\Events\SubscriptionStripeCustomerRegistered;
use FullRent\Core\Subscription\Events\SubscriptionToLandlordPlanCreated;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\StripeCardToken;
use FullRent\Core\Subscription\ValueObjects\StripeCustomer;
use FullRent\Core\Subscription\ValueObjects\SubscriptionId;
use FullRent\Core\ValueObjects\DateTime;
use SmoothPhp\EventSourcing\AggregateRoot;

/**
 * Class Subscription
 * @package FullRent\Core\Subscription
 * @author Simon Bennett <simon@bennett.im>
 */
final class Subscription extends AggregateRoot
{
    /**
     * @var SubscriptionId
     */
    private $id;

    /**
     * @var CompanyId
     */
    private $companyId;

    /**
     * @var StripeCustomer
     */
    private $stripCustomer;

    /**
     * @param SubscriptionId $id
     * @param CompanyId $companyId
     * @return Subscription
     */
    public static function startTrail(SubscriptionId $id, CompanyId $companyId, CardPaymentGateWay $cardPaymentGateWay)
    {
        $subscription = new static();
        $subscription->apply(new SubscriptionTrailStarted($id,
                                                          $companyId,
                                                          DateTime::now(),
                                                          DateTime::now()->addDays(14)->endOfDay()));

        $subscription->registerStripeCustomer($cardPaymentGateWay);

        return $subscription;
    }

    /**
     * @param CardPaymentGateWay $cardPaymentGateWay
     */
    private function registerStripeCustomer(CardPaymentGateWay $cardPaymentGateWay)
    {
        $stripeCustomer = $cardPaymentGateWay->registerCustomerWithNoCard($this->id, $this->companyId);
        $this->apply(new SubscriptionStripeCustomerRegistered($this->id, $stripeCustomer, DateTime::now()));
    }

    /**
     * @param StripeCardToken $stripeCardToken
     * @param CardPaymentGateWay $cardPayment
     */
    public function convertToLandlordPlan(StripeCardToken $stripeCardToken, CardPaymentGateWay $cardPayment)
    {
        $subscription = $cardPayment->subscribeToPlan($stripeCardToken, $this->stripCustomer, 'landlord');
        $this->apply(new SubscriptionToLandlordPlanCreated($this->id, $subscription));
    }


    /**
     * @param SubscriptionTrailStarted $e
     */
    protected function applySubscriptionTrailStarted(SubscriptionTrailStarted $e)
    {
        $this->id = $e->getId();
        $this->companyId = $e->getCompanyId();
    }

    /**
     * @param SubscriptionStripeCustomerRegistered $e
     */
    protected function applySubscriptionStripeCustomerRegistered(SubscriptionStripeCustomerRegistered $e)
    {
        $this->stripCustomer = $e->getStripCustomer();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'subscription-' . $this->id;
    }
}