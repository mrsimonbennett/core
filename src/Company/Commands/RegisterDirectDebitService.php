<?php
namespace FullRent\Core\Company\Commands;

/**
 * Class RegisterDirectDebitService
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterDirectDebitService
{
    /**
     * @var string
     */
    private $companyId;
    /**
     * @var string
     */
    private $directDebitAuthCode;

    /**
     * @param string $companyId
     * @param string $directDebitAuthCode
     */
    public function __construct($companyId, $directDebitAuthCode)
    {
        $this->companyId = $companyId;
        $this->directDebitAuthCode = $directDebitAuthCode;
    }

    /**
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getDirectDebitAuthCode()
    {
        return $this->directDebitAuthCode;
    }

}