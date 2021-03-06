<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
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
            [
                'app_id'     => getenv('CARDLESS_APP'),
                'app_secret' => getenv('CARDLESS_SECRET')
            ]
        );


    }

    /**
     *
     * @param string $redirectUrl
     * @param array $prePopulate
     * @return string
     * @throws \GoCardless_ArgumentsException
     */
    public function generateAuthorisationUrl($redirectUrl, $prePopulate = [])
    {
        $authorize_url_options = array(
            'redirect_uri' => $redirectUrl,
            'merchant'     => $prePopulate,
        );

        return $this->gocardlessClient->authorize_url($authorize_url_options);
    }

    /**
     * @param string $companyUrl
     * @param string $authorisationCode
     * @param $redirectPath
     * @return AccessTokens
     * @throws \GoCardless_ArgumentsException
     */
    public function getAccessToken($companyUrl, $authorisationCode, $redirectPath)
    {
        $domain = env('CARDLESS_REDIRECT');

        $params = array(
            'client_id'    => getenv('CARDLESS_APP'),
            'code'         => $authorisationCode,
            'redirect_uri' => "https://{$companyUrl}.{$domain}/{$redirectPath}",
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