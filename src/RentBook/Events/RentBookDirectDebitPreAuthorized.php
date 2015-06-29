<?php
namespace FullRent\Core\RentBook\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\RentBook\ValueObjects\RentBookId;
use FullRent\Core\Services\DirectDebit\GoCardLess\PreAuthorization;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class RentBookDirectDebitPreAuthorized
 * @package FullRent\Core\RentBook\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookDirectDebitPreAuthorized implements SerializableInterface
{
    /**
     * @var RentBookId
     */
    private $rentBookId;
    /**
     * @var PreAuthorization
     */
    private $preAuthorization;
    /**
     * @var DateTime
     */
    private $authorizedAt;

    /**
     * @param RentBookId $rentBookId
     * @param PreAuthorization $preAuthorization
     * @param DateTime $authorizedAt
     */
    public function __construct(RentBookId $rentBookId, PreAuthorization $preAuthorization, DateTime $authorizedAt)
    {
        $this->rentBookId = $rentBookId;
        $this->preAuthorization = $preAuthorization;
        $this->authorizedAt = $authorizedAt;
    }

    /**
     * @return RentBookId
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return PreAuthorization
     */
    public function getPreAuthorization()
    {
        return $this->preAuthorization;
    }

    /**
     * @return DateTime
     */
    public function getAuthorizedAt()
    {
        return $this->authorizedAt;
    }

    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new RentBookId($data['rent_book_id']),
                          PreAuthorization::deserialize($data['pre_authorization']),
                          DateTime::deserialize($data['authorized_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'rent_book_id'      => (string)$this->rentBookId,
            'pre_authorization' => $this->preAuthorization->serialize(),
            'authorized_at'     => $this->authorizedAt->serialize()
        ];
    }
}