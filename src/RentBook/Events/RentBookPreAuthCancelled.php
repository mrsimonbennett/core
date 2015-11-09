<?php
namespace FullRent\Core\RentBook\Events;

use SmoothPhp\Contracts\Serialization\Serializable;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookPreAuthCancelled
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookPreAuthCancelled implements Serializable, \SmoothPhp\Contracts\EventSourcing\Event
{
    /** @var RentBookId */
    private $id;

    /** @var DateTime */
    private $cancelledAt;

    /**
     * RentBookPreAuthCancelled constructor.
     * @param RentBookId $id
     * @param DateTime $cancelledAt
     */
    public function __construct(RentBookId $id, DateTime $cancelledAt)
    {
        $this->id = $id;
        $this->cancelledAt = $cancelledAt;
    }

    /**
     * @return RentBookId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCancelledAt()
    {
        return $this->cancelledAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']), DateTime::deserialize($data['cancelled_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return ['rent_book_id' => (string)$this->id, 'cancelled_at' => $this->cancelledAt->serialize()];
    }
}