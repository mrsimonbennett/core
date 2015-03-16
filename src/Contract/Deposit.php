<?php
namespace FullRent\Core\Contract;

use Carbon\Carbon;
use ValueObjects\Money\Money;

final class Deposit
{
    /**
     * @var DepositAmount
     */
    private $depositAmount;
    /**
     * @var Carbon
     */
    private $due;

    /**
     * @param DepositAmount $depositAmount
     * @param Carbon $due
     */
    public function __construct(DepositAmount $depositAmount, Carbon $due)
    {
        $this->depositAmount = $depositAmount;
        $this->due = $due;
    }

}