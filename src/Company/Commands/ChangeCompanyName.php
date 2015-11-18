<?php
namespace FullRent\Core\Company\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class ChangeCompanyName
 * @package FullRent\Core\Company\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeCompanyName extends BaseCommand
{
    private $companyId;

    private $companyName;

    /**
     * ChangeCompanyName constructor.
     * @param $companyId
     * @param $companyName
     */
    public function __construct($companyId, $companyName)
    {
        $this->companyId = $companyId;
        $this->companyName = $companyName;
        parent::__construct();

    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

}