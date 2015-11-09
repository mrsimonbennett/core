<?php
namespace FullRent\Core\Company\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RegisterDirectDebitService
 * @package FullRent\Core\Company\Commands
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

    /**
     * @param string $companyId
     * @param string $directDebitAuthCode
     */
    public function __construct($companyId, $directDebitAuthCode)
    {
        $this->companyId = $companyId;
        $this->directDebitAuthCode = $directDebitAuthCode;
        parent::__construct();

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