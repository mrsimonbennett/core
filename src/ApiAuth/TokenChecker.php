<?php
namespace FullRent\Core\ApiAuth;

use FullRent\Core\ApiAuth\Exceptions\InvalidApiToken;

/**
 * Interface TokenChecker
 * @package FullRent\Core\ApiAuth
 * @author Simon Bennett <simon@bennett.im>
 */
interface TokenChecker
{
    /**
     * @param $token
     * @param $requestUri
     * @return void
     * @throws InvalidApiToken
     */
    public function check($token,$requestUri);
}