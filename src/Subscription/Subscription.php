<?php
namespace FullRent\Core\Subscription;

use FullRent\Core\Subscription\Events\SubscriptionStripeCustomerRegistered;
use FullRent\Core\Subscription\Events\SubscriptionToLandlordPlanCreated;
use FullRent\Core\Subscription\Events\SubscriptionTrailStarted;
use FullRent\Core\Subscription\Services\CardPayment\CardPaymentGateWay;
use FullRent\Core\Subscription\ValueObjects\CompanyId;
use FullRent\Core\Subscription\ValueObjects\StripeCardToken;
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
     * @param SubscriptionId $id
     * @param CompanyId $companyId
     * @return Subscription
     */
    public static function startTrail(SubscriptionId $id, CompanyId $companyId)
    {
        $subscription = new static();
        $subscription->apply(new SubscriptionTrailStarted($id,
                                                          $companyId,
                                                          DateTime::now(),
                                                          DateTime::now()->addDays(14)->endOfDay()));

        return $subscription;
    }

    /**
     * @param StripeCardToken $stripeCardToken
     * @param CardPaymentGateWay $cardPayment
     */
    public function convertToLandlordPlan(StripeCardToken $stripeCardToken, CardPaymentGateWay $cardPayment)
    {
        $stripCustomer = $cardPayment->registerCustomer($stripeCardToken, $this->id);
        $this->apply(new SubscriptionStripeCustomerRegistered($this->id, $stripCustomer, DateTime::now()));

        $subscription = $cardPayment->subscribeToPlan($stripCustomer, 'landlord');
        $this->apply(new SubscriptionToLandlordPlanCreated($this->id, $subscription));
    }


    protected function applySubscriptionTrailStarted(SubscriptionTrailStarted $e)
    {
        $this->id = $e->getId();
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 'subscription-' . $this->id;
    }
}