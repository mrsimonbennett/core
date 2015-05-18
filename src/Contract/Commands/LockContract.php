<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class LockContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class LockContract
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
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

}