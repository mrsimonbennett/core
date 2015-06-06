<?php
namespace FullRent\Core\Deposit\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Deposit\ValueObjects\DepositId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class DepositManuallyPaid
 * @package FullRent\Core\Deposit\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class DepositManuallyPaid implements SerializableInterface
{
    /**
     * @var DepositId
     */
    private $depositId;
    /**
     * @var DateTime
     */
    private $paidAt;

    public function __construct(DepositId $depositId, DateTime $paidAt)
    {
        $this->depositId = $depositId;
        $this->paidAt = $paidAt;
    }

    /**
     * @return DepositId
     */
    public function getDepositId()
    {
        return $this->depositId;
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
        return new static(new DepositId($data['deposit_id']), DateTime::deserialize($data['paid_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'deposit_id' => (string)$this->depositId,
            'paid_at'    => $this->paidAt->serialize()
        ];
    }
}