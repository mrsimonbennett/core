<?php
namespace FullRent\Core\RentBook\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\RentBook\ValueObjects\RentBookRentId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentDueSet
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentDueSet implements SerializableInterface
{
    /**
     * @var RentBookId
     */
    private $rentBookId;
    /**
     * @var DateTime
     */
    private $paymentDue;
    /**
     * @var DateTime
     */
    private $setAt;
    /**
     * @var RentBookRentId
     */
    private $rentBookRentId;

    /**
     * @param RentBookId $rentBookId
     * @param DateTime $paymentDue
     * @param DateTime $setAt
     */
    public function __construct(
        RentBookId $rentBookId,
        RentBookRentId $rentBookRentId,
        DateTime $paymentDue,
        DateTime $setAt
    ) {
        $this->rentBookId = $rentBookId;
        $this->paymentDue = $paymentDue;
        $this->setAt = $setAt;
        $this->rentBookRentId = $rentBookRentId;
    }

    /**
     * @return RentBookId
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
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
    public function getPaymentDue()
    {
        return $this->paymentDue;
    }

    /**
     * @return DateTime
     */
    public function getSetAt()
    {
        return $this->setAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']),
                          new RentBookRentId($data['rent_book_rent_id']),
                          DateTime::deserialize($data['payment_due']),
                          DateTime::deserialize($data['set_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent_book_id'      => (string)$this->rentBookId,
            'rent_book_rent_id' => (string)$this->rentBookRentId,
            'payment_due'       => $this->paymentDue->serialize(),
            'set_at'            => $this->setAt->serialize()
        ];
    }
}