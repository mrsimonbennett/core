<?php
namespace FullRent\Core\Contract\ValueObjects;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\ValueObjects\DateTime;

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
    private $due;

    /**
     * @param DepositAmount $depositAmount
     * @param DateTime $due
     */
    public function __construct(DepositAmount $depositAmount, DateTime $due)
    {
        $this->depositAmount = $depositAmount;
        $this->due = $due;
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
    public function getDue()
    {
        return $this->due;
    }


    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(DepositAmount::deserialize($data['deposit']), DateTime::deserialize($data['due']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['deposit' => $this->depositAmount->serialize(), 'due' => $this->due->serialize()];
    }
}