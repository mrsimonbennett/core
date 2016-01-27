<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use FullRent\Core\Services\DirectDebit\Bill;
use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\Services\DirectDebit\DirectDebitUser;
use FullRent\Core\ValueObjects\DateTime;
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

    /**
     * GoCardlessDirectDebit constructor.
     */
    public function __construct()
    {
        GoCardless::$environment = 'sandbox';
        $this->gocardlessClient = new GoCardless_Client(
            [
                'app_id'     => getenv('CARDLESS_APP'),
                'app_secret' => getenv('CARDLESS_SECRET')
            ]
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
            'user'            => array(),
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
     * @return PreAuthorization
     */
    public function confirmPreAuthorization(
        AccessTokens $accessTokens,
        $resourceId,
        $resourceType,
        $resourceUri,
        $signature
    ) {
        $client = $this->generateClient($accessTokens);
        $confirmation = $client->confirm_resource(
            [
                'resource_id'   => $resourceId,
                'resource_type' => $resourceType,
                'resource_uri'  => $resourceUri,
                'signature'     => $signature
            ]
        );

        return new PreAuthorization($confirmation->id);

    }

    /**
     * @param AccessTokens $accessTokens
     * @param PreAuthorization $preAuthToken
     * @param $billName
     * @param $billAmount
     * @param $changeDate
     * @return Bill
     */
    public function createBill(
        AccessTokens $accessTokens,
        PreAuthorization $preAuthToken,
        $billName,
        $billAmount,
        DateTime $changeDate
    ) {
        $client = $this->generateClient($accessTokens);
        $preAuth = $client->pre_authorization($preAuthToken->getId());

        $bill = $preAuth->create_bill([
                                          'name'               => $billName,
                                          'amount'             => $billAmount,
                                          'charge_customer_at' => $changeDate->toDateString()
                                      ]);

        return Bill::fromGoCardless($bill);
    }

    /**
     * @param AccessTokens $accessTokens
     * @return GoCardless_Client
     */
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