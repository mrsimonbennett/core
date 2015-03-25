<?php
namespace FullRent\Core\ValueObjects\Money;

use Broadway\Serializer\SerializableInterface;
use InvalidArgumentException;

/**
 * Class Money
 * @author  Simon Bennett <simon@bennett.im>
 */
class Money implements SerializableInterface
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @param int $amount
     * @throws InvalidArgumentException
     */
    public function __construct($amount)
    {
        if (!is_int($amount)) {
            throw new InvalidArgumentException("Amount must be an integer. [{$amount}] passed");
        }

        $this->amount = $amount;
    }

    /**
     * @param $pounds
     * @return Money
     */
    public static function fromPounds($pounds)
    {
        return new static((int)$pounds * 100);
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return float|int
     */
    public function getAmountInPounds()
    {
        return $this->amount / 100;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "£" . number_format($this->getAmountInPounds(), 2, '.', '');
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['amount']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['amount' => $this->amount];
    }
}