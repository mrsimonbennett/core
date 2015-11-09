<?php
namespace FullRent\Core\RentBook\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\Services\DirectDebit\Bill;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookBillCreated
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookBillCreated implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /**
     * @var RentBookId
     */
    private $rentBookId;
    /**
     * @var Bill
     */
    private $bill;
    /**
     * @var RentBookRentId
     */
    private $rentBookRentId;
    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @param RentBookId $rentBookId
     * @param Bill $bill
     * @param RentBookRentId $rentBookRentId
     * @param DateTime $createdAt
     */
    public function __construct(RentBookId $rentBookId, Bill $bill, RentBookRentId $rentBookRentId, DateTime $createdAt)
    {
        $this->rentBookId = $rentBookId;
        $this->bill = $bill;
        $this->rentBookRentId = $rentBookRentId;
        $this->createdAt = $createdAt;
    }

    /**
     * @return RentBookId
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return Bill
     */
    public function getBill()
    {
        return $this->bill;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']),
                          Bill::deserialize($data['bill']),
                          new RentBookRentId($data['rent_book_rent_id']),
                          DateTime::deserialize($data['created_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent_book_id'      => (string)$this->rentBookId,
            'bill'              => $this->bill->serialize(),
            'rent_book_rent_id' => (string)$this->rentBookRentId,
            'created_at'        => $this->createdAt->serialize()
        ];
    }
}