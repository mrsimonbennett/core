<?php
namespace FullRent\Core\Contract\Commands;

/**
 * Class SetContractPeriod
 * @package FullRent\Core\Contract\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class SetContractPeriod 
{
    /**
     * @var string
     */
    private $contractId;
    /**
     * @var string
     */
    private $start;
    /**
     * @var string
     */
    private $end;

    /**
     * @param string $contractId
     * @param string $start
     * @param string $end
     */
    public function __construct($contractId, $start,$end)
    {
        $this->contractId = $contractId;
        $this->start = $start;
        $this->end = $end;
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
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

}