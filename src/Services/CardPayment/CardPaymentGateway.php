<?php
namespace FullRent\Core\Services\CardPayment;

use FullRent\Core\ValueObjects\Money\Money;

/**
 * Interface CardPaymentGateway
 * @package FullRent\Core\Services\CardPaymentGateWay
 * @author Simon Bennett <simon@bennett.im>
 */
interface CardPaymentGateway
{
    /**
     * @param CardDetails $cardDetails
     * @param Money $amount
     * @param $description
     * @return SuccessFullPayment
     */
    public function charge(CardDetails $cardDetails, Money $amount, $description);
}