<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class LandlordSignContract
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class LandlordSignContract
{
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $signature;

    /**
     * @param string $contractId
     * @param string$signature
     */
    public function __construct($contractId, $signature)
    {
        $this->contractId = $contractId;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getContractId()
    {
        return $this->contractId;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

}