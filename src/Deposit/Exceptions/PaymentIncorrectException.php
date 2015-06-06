<?php
namespace FullRent\Core\Deposit\Exceptions;

use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\PaymentAmount;

/**
 * Class PaymentIncorrect
 * @package FullRent\Core\Deposit\Exceptions
 * @author Simon Bennett <simon@bennett.im>
 */
final class PaymentIncorrectException extends \Exception
{
    public function __construct(PaymentAmount $paymentAmount, DepositAmount $depositAmount)
    {
        $this->message = "Tired to pay {$paymentAmount} but should have paid {$depositAmount}";
    }
}