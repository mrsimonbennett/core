<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use FullRent\Core\Services\DirectDebit\Bill;
use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\Services\DirectDebit\DirectDebitUser;
use GoCardless;
use GoCardless_Client;

/**
 * Class GoCardlessDirectDebit
 * @package FullRent\Core\Services\DirectDebit\GoCardLess
 * @author Simon Bennett <simon@bennett.im>
 */
final class GoCardlessDirectDebit implements DirectDebit
{
    /**
     * @var GoCardless_Client
     */
    private $gocardlessClient;

    public function __construct()
    {
        GoCardless::$environment = 'sandbox';
        $this->gocardlessClient = new GoCardless_Client(
            ['app_id' => getenv('CARDLESS_APP'), 'app_secret' => getenv('CARDLESS_SECRET')]
        );
    }
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
    ) {
        $payment_details = array(
            'max_amount'      => $maxPayment,
            'interval_length' => $rentInterval,
            'interval_unit'   => $rentUnit,
            'interval_count'  => $intervalCount + 1,
            'user'            => array(

            ),
            'redirect_uri'    => $redirectUrl,

        );
        $client = $this->generateClient($accessTokens);

        $pre_auth_url = $client->new_pre_authorization_url($payment_details);

        return htmlentities($pre_auth_url);
    }

    /**
     * @param AccessTokens $accessTokens
     * @param string $resourceId
     * @param string $resourceType
     * @param string $resourceUri
     * @param string $signature
     * @return string
     */
    public function confirmPreAuthorization(
        AccessTokens $accessTokens,
        $resourceId,
        $resourceType,
        $resourceUri,
        $signature
    ) {
        throw new \Exception('Not implemented [confirmPreAuthorization] method');
    }

    /**
     * @param AccessTokens $accessTokens
     * @param $preAuthToken
     * @param $billName
     * @param $billAmount
     * @param $changeDate
     * @return Bill
     */
    public function createBill(AccessTokens $accessTokens, $preAuthToken, $billName, $billAmount, $changeDate)
    {
        throw new \Exception('Not implemented [createBill] method');
    }

    private function generateClient(AccessTokens $accessTokens)
    {
        return new GoCardless_Client(
            [
                'app_id'       => getenv('CARDLESS_APP'),
                'app_secret'   => getenv('CARDLESS_SECRET'),
                'merchant_id'  => $accessTokens->getMerchantId(),
                'access_token' => $accessTokens->getAccessToken(),
            ]
        );
    }
}