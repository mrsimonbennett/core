<?php
namespace FullRent\Core\Subscription\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class StartCompanyTrail
 * @package FullRent\Core\Subscription\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class StartCompanyTrail extends BaseCommand
{
    /** @var string */
    private $companyId;

    /** @var string */
    private $subscriptionId;

    /**
     * StartCompanyTrail constructor.
     * @param string $companyId
     * @param string $subscriptionId
     */
    public function __construct($companyId, $subscriptionId)
    {
        $this->companyId = $companyId;
        $this->subscriptionId = $subscriptionId;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

}