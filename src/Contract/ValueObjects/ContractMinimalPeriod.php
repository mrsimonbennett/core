<?php
namespace FullRent\Core\Contract\ValueObjects;

use Carbon\Carbon;

/**
 * Class ContractMinimalPeriod
 * @package FullRent\Core\Contract
 * @author Simon Bennett <simon@bennett.im>
 */
final class ContractMinimalPeriod
{
    /**
     * @var Carbon
     */
    private $start;
    /**
     * @var Carbon
     */
    private $end;
    /**
     * @var bool
     */
    private $continue;

    /**
     * @param Carbon $start
     * @param Carbon $end
     * @param bool $continue Does contract continue after period
     */
    public function __construct(Carbon $start, Carbon $end, $continue)
    {
        $this->start = $start;
        $this->end = $end;
        $this->continue = $continue;
    }

    /**
     * @return Carbon
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return Carbon
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return boolean
     */
    public function isContinue()
    {
        return $this->continue;
    }


}