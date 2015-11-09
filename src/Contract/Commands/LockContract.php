<?php
namespace FullRent\Core\Contract\Commands;

use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class LockContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class LockContract extends BaseCommand
{
    /**
     * @var string
     */
    private $contractId;

    /**
     * @param string $contractId
     */
    public function __construct($contractId)
    {
        $this->contractId = $contractId;
        parent::__construct();

    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

}