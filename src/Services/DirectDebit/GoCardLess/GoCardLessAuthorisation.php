<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
use FullRent\Core\Services\DirectDebit\Landlord;
use GoCardless_Client;
use Illuminate\Config\Repository;

/**
 * Class GoCardLessAuthorisation
 * @package FullRent\Core\Services\DirectDebit\GoCardLess
 * @author Simon Bennett <simon@bennett.im>
 */
final class GoCardLessAuthorisation implements DirectDebitAccountAuthorisation
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->config = $repository;
        \GoCardless::$environment = env('CARDLESS_ENV');

        $this->gocardlessClient = new GoCardless_Client(
            ['app_id' => getenv('CARDLESS_APP'), 'app_secret' => getenv('CARDLESS_SECRET')]
        );


    }
    /**
     *
     * @param string $redirectUrl
     * @todo add the pre populate data
     * @return string
     */
    public function generateAuthorisationUrl($redirectUrl)
    {
        $authorize_url_options = array(
            'redirect_uri' => $redirectUrl,
            'merchant'     => []
        );

        return $this->gocardlessClient->authorize_url($authorize_url_options);    }

    /**
     * @param string $companyUrl
     * @param string $authorisationCode
     * @return AccessTokens
     */
    public function getAccessToken($companyUrl, $authorisationCode)
    {
        $params = array(
            'client_id'    => getenv('CARDLESS_APP'),
            'code'         => $authorisationCode,
            'redirect_uri' => "https://{$companyUrl}.fullrentcore.local/direct-debit/access_token",
            'grant_type'   => 'authorization_code',
        );

        $token = $this->gocardlessClient->fetch_access_token($params);

        return new GoCardLessAccessTokens($token['merchant_id'], $token['access_token']);

    }

    /**
     * @param $resourceId
     * @param $resourceType
     * @param $resourceUri
     * @param $signature
     * @param AccessTokens $accessTokens
     * @return mixed
     */
    public function confirmPreAuthorisation(
        $resourceId,
        $resourceType,
        $resourceUri,
        $signature,
        AccessTokens $accessTokens
    ) {
        throw new \Exception('Not implemented [confirmPreAuthorisation] method');
    }
}