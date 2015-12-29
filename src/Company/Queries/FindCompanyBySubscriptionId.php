<?php
namespace FullRent\Core\Company\Queries;

/**
 * Class FindCompanyBySubscriptionId
 * @package FullRent\Core\CompanyModal\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyBySubscriptionId
{
    private $subscriptionId;

    /**
     * FindCompanyBySubscriptionId constructor.
     * @param $subscriptionId
     */
    public function __construct($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

}