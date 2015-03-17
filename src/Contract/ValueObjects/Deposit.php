<?php
namespace FullRent\Core\Contract\ValueObjects;

use Carbon\Carbon;
use ValueObjects\Money\Money;

/**
 * Class Deposit
 * @package FullRent\Core\Contract\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
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