<?php
namespace FullRent\Core\Services\CardPayment;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\ValueObjects\Money\Money;

/**
 * Class SuccessFullPayment
 * @package FullRent\Core\Services\CardPaymentGateWay
 * @author Simon Bennett <simon@bennett.im>
 */
final class SuccessFullPayment implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var string
     */
    private $transactionId;
    /**
     * @var string
     */
    private $service;
    /**
     * @var Money
     */
    private $amount;
    /**
     * @var string
     */
    private $cardId;
    /**
     * @var used
     */
    private $extraInformation;

    /**
     * @param string $transactionId
     * @param string $service Atm Stripe
     * @param Money $amount
     * @param string $cardId the id the 3rd party uses to reference the card for later use
     * @param $extraInformation used to store the stripe log
     */
    public function __construct($transactionId, $service, Money $amount, $cardId, $extraInformation)
    {
        $this->transactionId = $transactionId;
        $this->service = $service;
        $this->amount = $amount;
        $this->cardId = $cardId;
        $this->extraInformation = $extraInformation;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @return Money
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * @return used
     */
    public function getExtraInformation()
    {
        return $this->extraInformation;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {

        return new static($data['transaction_id'],
                          $data['service'],
                          Money::deserialize($data['amount']),
                          $data['card_id'],
                          $data['extra_info']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'transaction_id' => $this->transactionId,
            'service'        => $this->service,
            'amount'         => $this->amount->serialize(),
            'card_id'        => $this->cardId,
            'extra_info'     => $this->extraInformation,
        ];
    }
}