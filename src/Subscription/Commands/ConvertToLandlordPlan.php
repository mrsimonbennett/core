<?php
namespace FullRent\Core\Subscription\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ConvertToLandlordPlan
 * @package FullRent\Core\Subscription\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ConvertToLandlordPlan extends BaseCommand
{
    /** @var string */
    private $subscriptionId;

    /** @var string */
    private $cardToken;

    /**
     * ConvertToLandlordPlan constructor.
     * @param string $subscriptionId
     * @param string $cardToken
     */
    public function __construct($subscriptionId, $cardToken)
    {
        $this->subscriptionId = $subscriptionId;
        $this->cardToken = $cardToken;

    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @return string
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

}