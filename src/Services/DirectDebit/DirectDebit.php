<?php
namespace FullRent\Core\Services\DirectDebit;

use FullRent\Core\Services\DirectDebit\GoCardLess\PreAuthorization;
use FullRent\Core\ValueObjects\DateTime;


/**
 * interface DirectDebitTenant
 * @package FullRent\Core\Services\DirectDebit
 * @author Simon Bennett <simon@bennett.im>
 */
interface DirectDebit
{

    /**
     * Generate the URL for setting up a pre authorized direct debit.
     *
     * Pass in the client to run the request on.
     *
     * @param double $maxPayment
     * @param DirectDebitUser $user
     * @param string $redirectUrl
     * @param AccessTokens $accessTokens
     * @param int $rentInterval
     * @param string $rentUnit
     * @param int $intervalCount
     * @return string
     */
    public function generatePreAuthorisationUrl(
        $maxPayment,
        DirectDebitUser $user,
        $redirectUrl,
        AccessTokens $accessTokens,
        $rentInterval = 1,
        $rentUnit = 'month',
        $intervalCount
    );

    /**
     * @param AccessTokens $accessTokens
     * @param string $resourceId
     * @param string $resourceType
     * @param string $resourceUri
     * @param string $signature
     * @return PreAuthorization
     */
    public function confirmPreAuthorization(
        AccessTokens $accessTokens,
        $resourceId,
        $resourceType,
        $resourceUri,
        $signature
    );

    /**
     * @param AccessTokens $accessTokens
     * @param PreAuthorization $preAuthToken
     * @param $billName
     * @param $billAmount
     * @param DateTime $changeDate
     * @return Bill
     */
    public function createBill(
        AccessTokens $accessTokens,
        PreAuthorization $preAuthToken,
        $billName,
        $billAmount,
        DateTime $changeDate
    );
}