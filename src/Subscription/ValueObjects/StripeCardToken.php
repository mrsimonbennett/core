<?php
namespace FullRent\Core\Subscription\ValueObjects;

use SmoothPhp\Contracts\Serialization\Serializable;

/**
 * Class StripeCardToken
 * @package FullRent\Core\Subscription\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class StripeCardToken implements Serializable
{
    private $cardToken;

    /**
     * StripeCardToken constructor.
     * @param $cardToken
     */
    public function __construct($cardToken)
    {
        $this->cardToken = $cardToken;
    }

    /**
     * @return mixed
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['card_token' => $this->cardToken];
    }

    /**
     * @param array $data
     * @return static
     */
    public static function deserialize(array $data)
    {
        return new static($data['card_token']);
    }
}