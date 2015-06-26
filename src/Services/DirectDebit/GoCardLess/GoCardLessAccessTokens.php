<?php
namespace FullRent\Core\Services\DirectDebit\GoCardLess;

use FullRent\Core\Services\DirectDebit\AccessTokens;

/**
 * Class GoCardLessAccessTokens
 * @package FullRent\Core\Services\DirectDebit\GoCardLess
 * @author Simon Bennett <simon@bennett.im>
 */
final class GoCardLessAccessTokens implements AccessTokens
{
    /**
     * @var string
     */
    private $merchantId;
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @param string $merchantId
     * @param string $accessToken
     */
    public function __construct($merchantId, $accessToken)
    {
        $this->merchantId = $merchantId;
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

}