<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\ValueObjects\DateTime;
use InvalidArgumentException;

/**
 * Class Deposit
 * @package FullRent\Core\Contract\ValueObjects
 * @author Simon Bennett <simon@bennett.im>
 */
final class Deposit implements SerializableInterface
{
    /**
     * @var DepositAmount
     */
    private $depositAmount;
    /**
     * @var DateTime
     */
    private $depositDue;
    /**
     * @var bool
     */
    private $fullRentProvided;

    public function __construct(DepositAmount $depositAmount, DateTime $depositDue, $fullRentProvided)
    {
        if (!is_bool($fullRentProvided)) {
            throw new InvalidArgumentException;
        }

        $this->depositAmount = $depositAmount;
        $this->depositDue = $depositDue;
        $this->fullRentProvided = $fullRentProvided;
    }

    /**
     * @return DepositAmount
     */
    public function getDepositAmount()
    {
        return $this->depositAmount;
    }

    /**
     * @return DateTime
     */
    public function getDepositDue()
    {
        return $this->depositDue;
    }

    /**
     * @return boolean
     */
    public function isFullRentProvided()
    {
        return $this->fullRentProvided;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(DepositAmount::deserialize($data['deposit']),
                          DateTime::deserialize($data['due']),
                          $data['fullrent_dps']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'deposit'      => $this->depositAmount->serialize(),
            'due'          => $this->depositDue->serialize(),
            'fullrent_dps' => $this->fullRentProvided
        ];
    }
}