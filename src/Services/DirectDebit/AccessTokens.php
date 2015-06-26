<?php
namespace FullRent\Core\Services\DirectDebit;

/**
 * Interface AccessTokens
 * @package FullRent\Core\Services\DirectDebit
 * @author Simon Bennett <simon@bennett.im>
 */
interface AccessTokens
{
    /**
     * @return string
     */
    public function getMerchantId();

    /**
     * @return string
     */
    public function getAccessToken();
}