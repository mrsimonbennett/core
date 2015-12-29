<?php
namespace FullRent\Core\Company\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RegisterDirectDebitService
 * @package FullRent\Core\CompanyModal\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RegisterDirectDebitService extends BaseCommand
{
    /**
     * @var string
     */
    private $companyId;

    /**
     * @var string
     */
    private $directDebitAuthCode;

    /** @var string */
    private $redirectPath;

    /**
     * @param string $companyId
     * @param string $directDebitAuthCode
     * @param string $redirectPath
     */
    public function __construct($companyId, $directDebitAuthCode, $redirectPath)
    {
        $this->companyId = $companyId;
        $this->directDebitAuthCode = $directDebitAuthCode;
        $this->redirectPath = $redirectPath;
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

    /**
     * @return string
     */
    public function getRedirectPath()
    {
        return $this->redirectPath;
    }

}