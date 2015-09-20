<?php
namespace FullRent\Core\RentBook\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class GoCardlessAcknowledgedRentBookBill
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class GoCardlessAcknowledgedRentBookBill implements SerializableInterface
{
    /** @var RentBookId */
    private $id;

    /** @var string */
    private $billId;

    /** @var DateTime */
    private $acknowledgedAt;

    /** @var RentBookRentId */
    private $rentBookRentId;

    /**
     * GoCardlessAcknowledgedRentBookBill constructor.
     * @param RentBookId $id
     * @param string $billId
     * @param RentBookRentId $rentBookRentId
     * @param DateTime $acknowledgedAt
     */
    public function __construct(RentBookId $id, $billId, RentBookRentId $rentBookRentId, DateTime $acknowledgedAt)
    {
        $this->id = $id;
        $this->billId = $billId;
        $this->acknowledgedAt = $acknowledgedAt;
        $this->rentBookRentId = $rentBookRentId;
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
     * @return DateTime
     */
    public function getAcknowledgedAt()
    {
        return $this->acknowledgedAt;
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
                          DateTime::deserialize($data['acknowledged_at']));
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
            'acknowledged_at'   => $this->acknowledgedAt->serialize()
        ];
    }

    /**
     * @return RentBookRentId
     */
    public function getRentBookRentId()
    {
        return $this->rentBookRentId;
    }
}