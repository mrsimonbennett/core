<?php
namespace FullRent\Core\Deposit\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Deposit\ValueObjects\DepositAmount;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\Deposit\ValueObjects\PaymentAmount;
use FullRent\Core\Services\CardPayment\SuccessFullPayment;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DepositPaid
 * @package FullRent\Core\Deposit\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositPaid implements SerializableInterface
{
    /**
     * @var DepositId
     */
    private $depositId;
    /**
     * @var PaymentAmount
     */
    private $paymentAmount;
    /**
     * @var DateTime
     */
    private $paidAt;
    /**
     * @var SuccessFullPayment
     */
    private $successFullPayment;

    /**
     * @param DepositId $depositId
     * @param PaymentAmount $paymentAmount
     * @param SuccessFullPayment $successFullPayment
     * @param DateTime $paidAt
     */
    public function __construct(
        DepositId $depositId,
        PaymentAmount $paymentAmount,
        SuccessFullPayment $successFullPayment,
        DateTime $paidAt
    ) {
        $this->depositId = $depositId;
        $this->paymentAmount = $paymentAmount;
        $this->paidAt = $paidAt;
        $this->successFullPayment = $successFullPayment;
    }

    /**
     * @return DepositId
     */
    public function getDepositId()
    {
        return $this->depositId;
    }

    /**
     * @return DepositAmount
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @return DateTime
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new DepositId($data['deposit_id']),
                          PaymentAmount::deserialize($data['payment_amount']),
                          SuccessFullPayment::deserialize($data['success_payment']),
                          DateTime::deserialize($data['paid_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'deposit_id'      => (string)$this->depositId,
            'payment_amount'  => $this->paymentAmount->serialize(),
            'paid_at'         => $this->paidAt->serialize(),
            'success_payment' => $this->successFullPayment->serialize(),
        ];
    }
}