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
     * @param array $prePopulate
     * @return string
     */
    public function generateAuthorisationUrl($redirectUrl,$prePopulate = []);

    /**
     * @param string $companyUrl
     * @param string $authorisationCode
     * @param $redirectPath
     * @return AccessTokens
     */
    public function getAccessToken($companyUrl, $authorisationCode, $redirectPath);


}