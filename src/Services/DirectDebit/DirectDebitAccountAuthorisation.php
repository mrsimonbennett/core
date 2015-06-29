<?php
namespace FullRent\Core\Services\DirectDebit;

/**
 * Interface DirectDebitAccountAuthorisation
 * @package FullRent\Core\Services\DirectDebit
 * @author Simon Bennett <simon@bennett.im>
 */
interface DirectDebitAccountAuthorisation
{
    /**
     * @param string $redirectUrl
     * @return string
     */
    public function generateAuthorisationUrl($redirectUrl);

    /**
     * @param string $companyUrl
     * @param string $authorisationCode
     * @return AccessTokens
     */
    public function getAccessToken($companyUrl, $authorisationCode);


}