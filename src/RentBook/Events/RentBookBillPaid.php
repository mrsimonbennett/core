<?php
namespace FullRent\Core\RentBook\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookBillPaid
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookBillPaid implements SerializableInterface
{
    /** @var RentBookId */
    private $id;

    /** @var string */
    private $billId;

    /** @var RentBookRentId */
    private $rentBookRentId;

    /** @var DateTime */
    private $paidAt;

    /** @var DateTime */
    private $receivedAt;

    /**
     * RentBookBillPaid constructor.
     * @param RentBookId $id
     * @param string $billId
     * @param RentBookRentId $rentBookRentId
     * @param DateTime $paidAt
     * @param DateTime $receivedAt
     */
    public function __construct(
        RentBookId $id,
        $billId,
        RentBookRentId $rentBookRentId,
        DateTime $paidAt,
        DateTime $receivedAt
    ) {
        $this->id = $id;
        $this->billId = $billId;
        $this->rentBookRentId = $rentBookRentId;
        $this->paidAt = $paidAt;
        $this->receivedAt = $receivedAt;
    }

    /**
     * @return RentBookId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * @return RentBookRentId
     */
    public function getRentBookRentId()
    {
        return $this->rentBookRentId;
    }

    /**
     * @return DateTime
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * @return DateTime
     */
    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']),
                          $data['bill_id'],
                          new RentBookRentId($data['rent_book_rent_id']),
                          DateTime::deserialize($data['paid_at']),
                          DateTime::deserialize($data['received_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent_book_id'      => (string)$this->id,
            'bill_id'           => $this->billId,
            'rent_book_rent_id' => (string)$this->rentBookRentId,
            'paid_at'           => $this->paidAt->serialize(),
            'received_at'       => $this->receivedAt->serialize(),
        ];
    }

}